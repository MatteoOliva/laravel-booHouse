<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Apartment extends Model
{
  use HasFactory;

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

  public function create_unique_slug()
  {
    // get all the slugs from the db
    $existing_slugs = Apartment::all()->pluck('slug')->toArray();
    // dd($existing_slugs);

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
}
