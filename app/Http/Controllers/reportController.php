<?php

namespace App\Http\Controllers;

use App\country;
use App\fund;
use App\organization;
use App\tag;
use Barryvdh\DomPDF\PDF;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class reportController extends Controller
{
    public function show($name){
      $country_id = country::where('name', $name)->get()[0]->id;
      $organization_id = organization::where('country_id', $country_id)->get()[0]->id;
      $funds = new Collection();
      $lengthTotal = 0;
      foreach ($this->getCategories() as $tag){
          $tmp = $tag["mainTag"]->funds()->where('visible',true)->where('organization_id', $organization_id)->with('tags', 'fields', 'organization')->orderBy('organization_id')->get();
          $fundsTmp = new Collection();
          foreach ($tmp as $fund){

              $categories = $fund->tags->all();

              $temp = [];
              foreach ($categories as $category){
                  $cat = tag::find($category["id"]);
                  $tempArray = [];
                  array_push($tempArray, $cat);
                  $catParent = $cat->parent;
                  while ($catParent){
                      array_push($tempArray, $catParent);
                      $catParent = $catParent->parent;
                  }
                  $tempArray = array_reverse($tempArray);
                  array_push($temp, $tempArray);
              }
              $fund->tags = $temp;
              $fundsTmp->push($fund);
          }
          $lengthTotal += $fundsTmp->count();
          $funds->push(["tag"=>$tag, "funds"=>$fundsTmp, "lengthTotal"=>$lengthTotal]);
      }
//      $funds = $funds->all();
//      $funds = tag::funds()->with('tags', 'organization', 'fields')->get();
//        return $funds[1]["funds"];
      return view('report')->with(compact('funds'));
    }

    private function getCategories(){
        $tagsInOrder = new Collection();
        $tags = tag::where('parent_id', 0)->get();
        foreach ($tags as $tag)
            $tagsInOrder->merge($this->findChildren($tag, $tagsInOrder));
        foreach ($tagsInOrder as $tagInOrder)
            {
                $tempArray = [];
                array_push($tempArray, $tagInOrder);
                $catParent = $tagInOrder->parent;
                while ($catParent){
                    array_push($tempArray, $catParent);
                    $catParent = $catParent->parent;
                }
                $tempArray = array_reverse($tempArray);
                $tagInOrder["mainTag"] = $tagInOrder;
                $tagInOrder["parents"] = $tempArray;
            }
        return $tagsInOrder;
    }

    private function findChildren(tag $tag,$collectedTags){
        $me = $tag;
        $me["is_parent"] = false;
        $children = $tag->children;
        if(!($children->isEmpty())) {
            $me["is_parent"] = true;
            $collectedTags->push($me);
            foreach ($children as $child)
                $collectedTags->merge($this->findChildren($child, $collectedTags));
        } else
            $collectedTags->push($tag);
        return $collectedTags;
    }

}
