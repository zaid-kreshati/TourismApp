<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Models\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Storage;

class CountryComponent extends Component
{

    use WithPagination, WithFileUploads, LivewireAlert;


    public $modalFormVisible = false;
    public $updateVisible = false;

    public $countryUpdatedId;
    public $name;
    public $details;
    public $image;
    public $image_name;
    public $img_id;


    //----- Store created dest
    public function showCreateModal()
    {
        $this->modalFormVisible = true;
    }
    public function store()
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



        Country::create([
            'name' => $this->name,
            'details' => $this->details,
            'img_id' => $this->img_id,
            'popular'=>1,
        ]);

        $this->modalFormReset();
        $this->modalFormVisible = false;

        $this->alert('success', 'Country Created Succeffully');
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

        $this->countryUpdatedId= $id;
    }
    public function loadData($country_id)
    {
        $data = Country::find($country_id);
        $this->name = $data->name;
        $this->details = $data->details;

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



        $dest = Country::find($this->countryUpdatedId);
        $dest->name = $this->name;
        $dest->details = $this->details;
        $dest->img_id = $this->img_id;
        $dest->save();


        $this->modalFormReset();
        $this->alert('success', 'Destination ' . $this->countryUpdatedId . ' Updated Succeffully');
        $this->updateVisible = false;

    }


    //----- Delete Dest 
    public function deleteDest($country_id)
    {
        $this->alert('warning', ' Destination Deleted ! ', ['timer' => 3000]);
        $country = Country::findOrFail($country_id);
        if ($country->image->data) {
            // Storage::delete('public/storage/images/' . $post->image); NOTE DELETED

            // this is right path 
            Storage::disk('public')->delete('images/' . $country->image);
        }
        $country->delete();
    }



    public function all_country()
    {
        return Country::orderByDesc('id')->paginate(2);
    }
    public function modalFormReset()
    {
        $this->name = null;
        $this->details = null;
    }
    public function render()
    {
        return view('livewire.country-component', [
            'countries' => $this->all_country(),
        ])->with('message', session('message'));
    }
}
