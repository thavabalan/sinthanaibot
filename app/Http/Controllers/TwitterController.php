<?php

namespace App\Http\Controllers;
use Atymic\Twitter\Facade\Twitter;
use Storage;
use File;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Author;
class TwitterController extends Controller
{
    public function tweet()
    {
    	

    	$vara = Quote::pluck('qte')->random();
        $author = Author::pluck('name')->first();
        $qoute = $vara.'-'.$author.' #TamilsLeaderPrabhakaran';
        $directory= public_path() . '/images/';
        $filelist = Storage::allFiles('public/images');
        $randomFile = $filelist[rand(0, count($filelist) - 1)];
        $filename = storage_path().'/app/'.$randomFile;
        $str = str_replace('\\', '/', $filename);
        $data = base64_encode($str);
    	
        $uploaded_media = Twitter::uploadMedia(['media' => File::get($str)]);
        $newTwitte = ['status' => $qoute,'media_ids' => $uploaded_media->media_id_string];
    	$twitter = Twitter::postTweet($newTwitte);

    	
    	return $filename;
    }
}
