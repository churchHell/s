<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Str;

class ItemRepository implements Contracts\ItemRepositoryContract
{

    // public function find(int $id): Collection
    // {
    //     $item = $this->getItemInfo($this->getItemUrl($id));
    //     if(!$this->isItemValid($item)){
    //         throw new NotFoundException('item');
    //     }
    //     $item = $this->replaceKeys($item);
    //     return $item;
    // }

     public function findAll(string $sids): Collection {
         $items = collect();
         $href = $this->getItemsUrl($sids);
         while($href){
             $info = $this->getItemInfo($href)->mapInto(Collection::class);
             $items->push($info->get('items', collect()));
             $href = $this->getNextLink($info);
         }
         $validatedItems = $items->collapse()->mapInto(Collection::class)->filter(function($item){
             return $this->isItemValid($item);
         });
         return $validatedItems->keyBy('id');
     }

    public function where(string $column, string $value): Collection 
    {
        $items = $this->getItemInfo($this->getItemUrl($column, $value))
            ->mapInto(Collection::class);
        $item = collect(data_get($items, 'items.0'));
        throw_unless($this->isItemValid($item), NotFoundException::class, 'item');
        $item = $this->replaceKeys($item);
        return $item;
    }

    protected function getItemUrl(string $key, string $value): string {
        return config('api.url').'/item/?with_adult=1&'.$key.'='.$value;
    }

    // protected function getItemUrl(int $id): string {
    //     return config('api.url').'/item/'.$id.'/?with_adult=1';
    // }

     protected function getItemsUrl(string $ids): string {
         return config('api.url').'/item/?with_adult=1&sid='.$ids;
     }

    protected function getItemInfo(string $url): Collection
    {
        return collect(Curl::to($url)->withContentType('application/json')->asJson()->get());
    }
    
    private function isItemValid(Collection $data): bool
    {
        $validator = Validator::make($data->all(), [
            'id' => 'required|int|min:1',
            'sid' => 'required|int|min:1',
            'name' => 'required|string',
            'itemUrl' => 'required|string',
            'img' => 'required|url',
            'price' => 'required|numeric',
            'currency' => 'required|string',
            'minQty' => 'required|int|min:0',
            'pluralNameFormat' => 'required|string',
        ]);
        return $validator->passes();
    }
        
     private function getNextLink(Collection $data): ?string
     {
         return optional(data_get($data, '_links.next'))->href;
     }
    
    private function replaceKeys(Collection $item): Collection
    {
        $item = $item->mapWithKeys( fn($item, $key) => [Str::snake($key) => $item] );
        $item->put('pid', $item->get('id'));
        $item->put('url', $item->get('item_url'));
        return $item;
    }
	
}
