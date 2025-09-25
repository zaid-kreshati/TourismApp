<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Country;
use App\Models\Image;
use App\Models\TouristDes;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Storage;

class Destenation extends Component
{

    use WithPagination , WithFileUploads , LivewireAlert;

    public $modalFormVisible = false;
    public $updateVisible = false;

    public $destUpdatedId;
    public $name;
    public $details;
    public $image;
    public $image_name;
    public $img_id;
    public $category;
    public $country;

    // Validation
    public function rules()
    {
        return [
            'name' => ['required'],
            'details' => ['required'],
            'image' => ['required'],
            'country' => ['required'],
            'category' => ['required'],
        ];
    }


    


    //----- update Stuff
    public function showUpdateModal($id) {
        $this->updateVisible = true;
        $this->loadData($id);
        $this->alert('info', $id, [
            'position' => 'top-end',
            'timer' => 1000,
            'toast' => true
        ]);

        $this->destUpdatedId = $id;
    }
    public function loadData($dest_id) {
        $data = TouristDes::find($dest_id);
        $this->name = $data->name;
        $this->details = $data->details;
        $this->country = $data->country->name;
        $this->category = $data->category->name;
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

        $categ = Category::where('name', 'LIKE', '%' . $this->category . '%')->first();
        $countr = Country::where('name', 'LIKE', '%' . $this->country . '%')->first();

        $dest = TouristDes::find($this->destUpdatedId);
        $dest->name = $this->name;
        $dest->details = $this->details;
        $dest->img_id = $this->img_id;
        $dest->country_id = $countr->id;
        $dest->categ_id = $categ->id;
        $dest->save();


        $this->modalFormReset();
        $this->alert('success', 'Destination ' . $this->destUpdatedId . ' Updated Succeffully');
        $this->updateVisible = false;

    }




    //----- Store created dest
    public function showCreateModal(){
        $this->modalFormVisible = true;
    }
    public function store() {
        $this->validate();

        if ($this->image) {
            $this->image_name = $this->image->getClientOriginalName();

            // Create image in table and get the id
            $id = Image::create([
                'data'=>$this->image_name
            ]);
            $this->img_id = $id->id;
            
            // will stored in public/storage/images directory 
            $this->image->storeAs('public/images/', $this->image_name);
        }

        $categ = Category::where('name' , 'LIKE' ,'%' . $this->category . '%')->first();
        $countr = Country::where('name' , 'LIKE' ,'%'. $this->country . '%')->first();

        TouristDes::create([
            'name' => $this->name,
            'details' => $this->details,
            'img_id' => $this->img_id,
            'categ_id'=> $categ->id,
            'country_id'=> $countr->id,
        ]);

        $this->modalFormReset();
        $this->modalFormVisible = false;

        $this->alert('success', 'Destination Created Succeffully');
    }

    
    //----- Delete Dest 
    public function deleteDest($dest_id)
    {
        $this->alert('warning', ' Destination Deleted ! ', ['timer' => 3000]);
        $dest = TouristDes::findOrFail($dest_id);
        if ($dest->image->data) {
            // Storage::delete('public/storage/images/' . $post->image); NOTE DELETED

            // this is right path 
            Storage::disk('public')->delete('images/' . $dest->image);
        }
        $dest->delete();
    }




    public function all_dest() {
        return TouristDes::orderByDesc('id')->paginate(4);
    }
    public function modalFormReset() {
        $this->name = null;
        $this->details = null;
        $this->country = null;
        $this->category = null;
    }
    public function render()
    {
        return view('livewire.destenation' , [
            'dests' => $this->all_dest(),
        ])->with('message', session('message'));
    }
}
