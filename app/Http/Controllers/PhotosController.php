<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;

class PhotosController extends Controller
{
  public function create(int $albumId)
  {
    return view('photos.create', ['albumId' => $albumId]);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'title' => 'required',
      'description' => 'required',
      'photo' => 'required|image',
    ]);

    $filenameWithExtension = $request->file('photo')->getClientOriginalName();
    $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
    $extension = $request->file('photo')->getClientOriginalExtension();
    // put the filename back together with timestamp
    $filenameToStore = sprintf('%s_%d.%s', $filename, time(), $extension);

    // save the image in the app
    $path = $request->file('photo')->storeAs(sprintf('public/albums/%s', $request->input('album-id')), $filenameToStore);

    // create the model and save
    $photo = new Photo;
    $photo->title = $request->input('title');
    $photo->album_id = $request->input('album-id');
    $photo->description = $request->input('description');
    $photo->photo = $filenameToStore;
    $photo->size = $request->file('photo')->getSize();
    $photo->save();

    return redirect('/albums/' . $request->input('album-id'))->with('success', 'Photo added successfully!');
  }

  public function show($id)
  {
    $photo = Photo::find($id);
    return view('photos.show')->with('photo', $photo);
  }

  public function destroy($id)
  {
    $photo = Photo::find($id);
    $path = sprintf('public/albums/%s/%s', $photo->album_id, $photo->photo);
    if (Storage::delete($path)){
      $photo->delete();
      return redirect('/')->with('success', 'Photo deleted Successfully!');
    }
  }
}
