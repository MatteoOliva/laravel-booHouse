<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Array_;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $dates = ['deleted_at'];

  protected $fillable = [
    'user_id',
    'title',
    'slug',
    'description',
    'rooms',
    'beds',
    'toilets',
    'mq',
    'image',
    'lat',
    'lon',
    'address',
    'visible'
  ];


  // public function deleteApartment($id){
  //     $apartment = Apartment::find($id);
  //     $apartment->delete(); // This soft deletes the apartment
  //   }


  // public function restoreApartment($id){
  //   $apartment = Apartment::withTrashed()->find($id);
  //   $apartment->restore(); // This restores the soft-deleted apartment
  // }

  public function create_unique_slug(array $existing_slugs)
  {
    // create a slug from the title
    $new_slug = Str::slug($this->title);

    // check if this new slug already exist in the db
    while (in_array($new_slug, $existing_slugs)) {

      // get only the last 2 carachters of the slug then parse them into int
      $last_digits = substr($new_slug, strlen($new_slug) - 2);
      $last_num = (int) $last_digits;

      // if this is a number 
      if ($last_num != 0) {

        // add 1 
        $new_num = $last_num + 1;
        // then if the num is < 10 add a 0 before it
        if ($new_num < 10) $new_num = '0' . $new_num;
        // get all the slug except the last 2 characters
        $slug_text = substr($new_slug, 0, -3);
      } else {

        // the new num to add will be 01
        $new_num = '01';
        // the slug text will be = to the whole slug
        $slug_text = $new_slug;
      }

      // then add the number to the text of the slug
      $new_slug = $slug_text . '-' . $new_num;
    }

    return $new_slug;
  }

  public function get_img_absolute_path()
  {
    //crea variabile vuota per path immagine
    $image_path = '';
    // se l'url dell'immagine inizia per img
    if (substr($this->image, 0, 3) == 'img') {
      // salva nella var l'url dell'immagine dalla cartella img
      $image_path = asset('/' . $this->image);
    } else {
      //salva nella var l'url dell'immagine dalla cartella storage
      $image_path =  asset('/storage/' . $this->image);
    }
    // restituisci il path dell'immagine
    return $image_path;
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function services()
  {
    return $this->belongsToMany(Service::class);
  }
  public function messages()
  {
    return $this->hasMany(Message::class);
  }
  public function views()
  {
    return $this->hasMany(View::class);
  }
  public function sponsorships()
  {
    return $this->belongsToMany(Sponsorship::class);
  }
  public function getRouteKeyName()
  {
    return 'slug';
  }
}
