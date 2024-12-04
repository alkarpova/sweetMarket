<?php

namespace App\Livewire\Auth\Modal;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use LivewireUI\Modal\ModalComponent;

class EditProfile extends ModalComponent
{
    public ?User $user = null;

    public ?string $name = null;

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $country = null;

    public ?string $region = null;

    public ?string $city = null;

    public ?string $address = null;

    public Collection $countries;

    public Collection $regions;

    public Collection $cities;

    public function mount(): void
    {
        $this->user = auth()->user();

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->country = $this->user->country_id;
        $this->region = $this->user->region_id;
        $this->city = $this->user->city_id;
        $this->address = $this->user->address;

        $this->countries = Country::where('status', true)
            ->get();

        $this->regions = Region::where('status', true)
            ->get();

        $this->cities = City::where('status', true)
            ->get();
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'country' => 'required|exists:countries,id',
            'region' => 'required|exists:regions,id',
            'city' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country_id' => $this->country,
            'region_id' => $this->region,
            'city_id' => $this->city,
            'address' => $this->address,
        ]);

        $this->forceClose()->closeModal();
        $this->dispatch('alert', $message = 'Profile updated successfully.', $type = 'success');
        $this->dispatch('userUpdated');
    }

    public function render()
    {
        return view('livewire.auth.modal.edit-profile');
    }
}
