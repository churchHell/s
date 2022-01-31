<?php

namespace App\Repositories;

use Ixudra\Curl\Facades\Curl;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class DeliveryRepository extends Repository implements Contracts\DeliveryRepositoryContract
{

    public function getPrice(int $sid, int $qty): Collection 
    {
        $delivery = $this->sendDeliveryQuery(
            $this->getDeliveryData([compact('sid', 'qty')])
        )->first();
        throw_if(!$this->isDeliveryValid($delivery), NotFoundException::class, 'delivery');
        return $delivery;
    }
    
    public function getPrices(Collection $items): Collection
    {
        $deliveries = $this->sendDeliveryQuery($this->getDeliveryData($items->toArray()));
        $filtered = $deliveries->filter( fn($delivery) => $this->isDeliveryValid($delivery) );
        return $filtered;
    }
    
    protected function sendDeliveryQuery(array $data): Collection
    {
        return collect(
            Curl::to($this->getDeliveryPriceUrl())
                ->withData($data)
                ->asJson()
                ->post()
            )
            ->mapInto(Collection::class);
    }

    protected function getDeliveryData(array $data): array {
        return [
            'settlement_id' => 193824312,
            'items' => $data,
        ];
    }

    protected function getDeliveryPriceUrl(): string {
        return config('api.url').'/delivery-calc/';
    }
    
    private function isDeliveryValid(Collection $delivery): bool
    {
        $validator = Validator::make($delivery->all(), [
            'sid' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0',
        ]);
        return $validator->passes();
    }

}
