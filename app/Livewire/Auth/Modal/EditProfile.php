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

    public ?string $country_id = null;

    public ?string $region_id = null;

    public ?string $city_id = null;

    public ?string $address = null;

    public Collection $countries;

    public Collection $regions;

    public Collection $cities;

    public function mount(): void
    {
        $this->user = User::find(auth()->user()->id);

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->country_id = $this->user->country_id;
        $this->region_id = $this->user->region_id;
        $this->city_id = $this->user->city_id;
        $this->address = $this->user->address;

        $this->countries = Country::where('status', true)->get();
        $this->regions = Region::where('status', true)->get();
        $this->cities = City::where('status', true)->get();
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|email|min:4|max:64|unique:users,email,'.$this->user->id,
            'phone' => 'nullable|string|min:8|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'region_id' => 'nullable|exists:regions,id',
            'city_id' => 'nullable|exists:cities,id',
            'address' => 'nullable|string|max:255',
        ]);

        User::where('id', $this->user->id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country_id' => $this->country_id === '' ? null : $this->country_id,
            'region_id' => $this->region_id === '' ? null : $this->region_id,
            'city_id' => $this->city_id === '' ? null : $this->city_id,
            'address' => trim($this->address),
        ]);

        $this->forceClose()->closeModal();
        $this->dispatch('alert', 'Profile updated successfully.', 'success');
        $this->dispatch('userUpdated');
    }

    public function render()
    {
        return view('livewire.auth.modal.edit-profile');
    }
}
