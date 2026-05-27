<?php

namespace App\Services;

use Illuminate\Support\Collection;

class TempHotelService
{
    public function getAllHotels(): Collection
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Grand Plaza Moscow',
                'city' => 'Москва',
                'country' => 'Россия',
                'address' => 'ул. Тверская, д. 10',
                'description' => 'Роскошный 5-звездочный отель в центре Москвы',
                'stars' => 5,
                'price_per_night' => 15000,
                'phone' => '+7 (495) 123-45-67',
                'email' => 'info@grandplaza.ru',
                'image' => null,
                'is_available' => true,
            ],
            (object) [
                'id' => 2,
                'name' => 'Nevsky Palace',
                'city' => 'Санкт-Петербург',
                'country' => 'Россия',
                'address' => 'Невский пр., д. 88',
                'description' => 'Элегантный отель на Невском проспекте',
                'stars' => 4,
                'price_per_night' => 8500,
                'phone' => '+7 (812) 555-12-34',
                'email' => 'booking@nevskypalace.ru',
                'image' => null,
                'is_available' => true,
            ],
            (object) [
                'id' => 3,
                'name' => 'Kazan Kremlin Hotel',
                'city' => 'Казань',
                'country' => 'Россия',
                'address' => 'ул. Баумана, д. 20',
                'description' => 'Отель с видом на Казанский Кремль',
                'stars' => 4,
                'price_per_night' => 6000,
                'phone' => '+7 (843) 222-33-44',
                'email' => 'info@kazankremlin.ru',
                'image' => null,
                'is_available' => true,
            ],
            (object) [
                'id' => 4,
                'name' => 'Sochi Beach Resort',
                'city' => 'Сочи',
                'country' => 'Россия',
                'address' => 'ул. Приморская, д. 15',
                'description' => 'Курортный отель у самого моря',
                'stars' => 5,
                'price_per_night' => 12000,
                'phone' => '+7 (862) 777-88-99',
                'email' => 'resort@sochibeach.ru',
                'image' => null,
                'is_available' => true,
            ],
            (object) [
                'id' => 5,
                'name' => 'Comfort Inn Moscow',
                'city' => 'Москва',
                'country' => 'Россия',
                'address' => 'ул. Арбат, д. 25',
                'description' => 'Уютный отель эконом-класса',
                'stars' => 3,
                'price_per_night' => 3500,
                'phone' => '+7 (495) 987-65-43',
                'email' => 'info@comfortinn.ru',
                'image' => null,
                'is_available' => true,
            ],
        ]);
    }

    public function getPopularHotels(): Collection
    {
        return $this->getAllHotels()->take(6);
    }

    public function getHotelById($id)
    {
        return $this->getAllHotels()->firstWhere('id', (int)$id);
    }
}