<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Models\Hotel;
use App\Models\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Storage;

class HotelsComponent extends Component
{

    use WithPagination, WithFileUploads, LivewireAlert;

    public $modalFormVisible = false;
    public $updateVisible = false;

    public $hotelUpdatedId;
    public $name;
    public $rating;
    public $image;
    public $image_name;
    public $img_id;
    public $price;
    public $country;


    //----- Store created dest
    public function showCreateModal()
    {
        $this->modalFormVisible = true;
    }
    public function store()
    {
        // $this->validate();

        if ($this->image) {
            $this->image_name = $this->image->getClientOriginalName();

            // Create image in table and get the id
            $id = Image::create([
                'data' => $this->image_name
            ]);
            $this->img_id = $id->id;

            // will stored in public/storage/images directory 
            $this->image->storeAs('public/images/', $this->image_name);
        }


        $countr = Country::where('name', 'LIKE', '%' . $this->country . '%')->first();

        Hotel::create([
            'name' => $this->name,
            'rating' => $this->rating,
            'price_night' => $this->price,
            'img_id' => $this->img_id,
            'country_id' => $countr->id,
        ]);

        $this->modalFormReset();
        $this->modalFormVisible = false;

        $this->alert('success', 'Hotel Created Succeffully');
    }




    //----- update Stuff
    public function showUpdateModal($id)
    {
        $this->updateVisible = true;
        $this->loadData($id);
        $this->alert('info', $id, [
            'position' => 'top-end',
            'timer' => 1000,
            'toast' => true
        ]);

        $this->hotelUpdatedId = $id;
    }
    public function loadData($dest_id)
    {
        $data = Hotel::find($dest_id);
        $this->name = $data->name;
        $this->rating = $data->rating;
        $this->country = $data->country->name;
        $this->price = $data->price_night;
    }
    public function update()
    {

        if ($this->image) {
            $this->image_name = $this->image->getClientOriginalName();

            // Create image in table and get the id
            $id = Image::create([
                'data' => $this->image_name
            ]);
            $this->img_id = $id->id;

            // will stored in public/storage/images directory 
            $this->image->storeAs('public/images/', $this->image_name);
        }

        $countr = Country::where('name', 'LIKE', '%' . $this->country . '%')->first();

        $hotel = Hotel::find($this->hotelUpdatedId);
        $hotel->name = $this->name;
        $hotel->img_id = $this->img_id;
        $hotel->country_id = $countr->id;
        $hotel->rating = $this->rating;
        $hotel->price_night = $this->price;
        $hotel->save();


        $this->modalFormReset();
        $this->alert('success', 'Hotel ' . $this->hotelUpdatedId . ' Updated Succeffully');
        $this->updateVisible = false;

    }



    //----- Delete Dest 
    public function deleteDest($dest_id)
    {
        $this->alert('warning', ' Destination Deleted ! ', ['timer' => 3000]);
        $hotel = Hotel::findOrFail($dest_id);
        if ($hotel->image->data) {
            // Storage::delete('public/storage/images/' . $post->image); NOTE DELETED

            // this is right path 
            Storage::disk('public')->delete('images/' . $hotel->image);
        }
        $hotel->delete();
    }





    public function all_hotels()
    {
        return Hotel::orderByDesc('id')->paginate(4);
    }
    public function modalFormReset()
    {
        $this->name = null;
        $this->rating = null;
        $this->country = null;
        $this->price = null;
    }
    public function render()
    {
        return view('livewire.hotels-component', [
            'hotels' => $this->all_hotels(),
        ])->with('message', session('message'));
    }
}
