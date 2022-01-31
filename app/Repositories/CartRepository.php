<?php

namespace App\Repositories;

use Exception;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class CartRepository extends Repository implements Contracts\CartRepositoryContract
{

    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function send(int $id, int $sid, int $qty): ?Collection
    {
        $request = collect(Curl::to($this->getUrl())
            ->withOption('USERPWD', $this->getAuth())
            ->withData(['item_id' => $id, 'item_sid' => $sid, 'qty' => $qty])
            ->asJson()
            ->post());

        throw_if($this->isUnauthorized($request), new Exception(__('wrong.credentials')));

        return $this->isValid($request) ? $request : null;
    }
    
    private function isValid(Collection $data): bool
    {
        $validator = Validator::make($data->all(), [
            'qty' => 'required|integer|min:0'
        ]);
        return $validator->passes();
    }

    private function isUnauthorized(Collection $request): bool
    {
        return $request->has('status') && $request->get('status') == 401;
    }

    protected function getUrl(): string
    {
        return config('api.url').'/cart-item/';
    }

    protected function getAuth(): string
    {
        return $this->email.':'.$this->password;
    }

}