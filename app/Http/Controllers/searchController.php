<?php

namespace App\Http\Controllers;

use App\country;
use App\field;
use App\fund;
use App\organization;
use App\tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class searchController extends Controller
{


    public function search(Request $r){
        $filter = $r->filter;
        $offset = $r->offset * 5;

//        return $filter;
        if(isset($filter['$org_ids']))
            $org_ids = $filter['$org_ids'];
        else
            $org_ids = [];

        if(isset($filter['$field_ids']))
            $field_ids = $filter['$field_ids'];
        else
            $field_ids = [];

        if(isset($filter['$tag_ids']))
            $tag_ids = $filter['$tag_ids'];
        else
            $tag_ids = [];

        if(isset($filter['$visible']))
            $visible = intval($filter['$visible']);
        else
            $visible = 1;

        if(isset($filter['$country_ids']))
            $country_ids = $filter['$country_ids'];
        else
            $country_ids = [];

        if(isset($filter['$text']))
            $text = $filter['$text'];
        else
            $text = "";

        $ratings = [];

        $filteredByText = $this->searchByText($text);
        $filteredByOrgs = $this->filterByOrg($filteredByText, $org_ids);
        $filteredByOrgsNFields = $this->filterByField($filteredByOrgs, $field_ids);
        $filteredByOrgFieldTag = $this->filterByTag($filteredByOrgsNFields, $tag_ids);
        $filteredByOrgFieldTagCountry = $this->filterByCountry($filteredByOrgFieldTag, $country_ids);
        $final = $this->filterByRating($filteredByOrgFieldTagCountry, $ratings);
        $count = fund::find($final)->count();
        if($r->user())
            $Results = fund::where('visible',$visible)->with('organization')->find($final)->toArray();
        else
            $Results = fund::where('visible',$visible)->with('organization')->find($final)->toArray();
        $finalResults = array_slice($Results,$offset,8);
        return response()->json(['count'=> $count, 'result'=>$finalResults]);
    }

    private function filterByOrg($before, $org_ids){

        if(empty($org_ids))
            return $before;
        $res = array();
        $tmp = organization::find($org_ids);
        foreach ($tmp as $t){
            foreach ($t->funds as $fund)
                if(in_array($fund->id, $before))
                     array_push($res, $fund->id);
        }
        return array_unique($res);
    }


    private function filterByField($filteredBeforeResult, $field_ids){
        if(empty($field_ids))
            return $filteredBeforeResult;
        $ree = array();
        $rmp = field::find($field_ids);
        foreach ($rmp as $r){
            foreach ($r->funds as $fund)
                if(in_array($fund->id, $filteredBeforeResult))
                    array_push($ree, $fund->id);
        }
        return array_unique($ree);
    }

    private function filterByTag($filteredBeforeResult, $tag_ids){
        if(empty($tag_ids))
            return $filteredBeforeResult;
        $ree = array();
        $rmp = tag::find($tag_ids);


        foreach ($rmp as $r){
            $collectedTags = collect([$r]);
            $toBeLooked = $this->findChildren($r, $collectedTags);

            foreach ($toBeLooked as $t)
                foreach ($t->funds as $fund)
                    if(in_array($fund->id, $filteredBeforeResult))
                        array_push($ree, $fund->id);
        }

        return array_unique($ree);
    }


    private function findChildren(tag $tag,$collectedTags){
        $children = $tag->children;
        if(!($children->isEmpty())) {
            foreach ($children as $child)
                $collectedTags->merge($this->findChildren($child, $collectedTags));
        } else
            $collectedTags->push($tag);
        return $collectedTags;
    }

    private function filterByCountry($filteredBeforeResult, $country_ids){
        if(empty($country_ids))
            return $filteredBeforeResult;
        $ree = array();
        $rmp = country::find($country_ids);
        foreach ($rmp as $r){
            foreach ($r->funds as $fund)
                if(in_array($fund->id, $filteredBeforeResult))
                    array_push($ree, $fund->id);
        }

        return array_unique($ree);
    }

    private function filterByRating($before, $ratings){
        if(empty($ratings))
            return $before;
        $res = array();
        foreach ($ratings as $rating){
            $funds = fund::where('rating', $rating)->get();
            foreach ($funds as $fund)
                if(in_array($fund->id, $before))
                    array_push($res, $fund->id);
        }

        return $res;
    }


    private function searchByText($searchString){
        $res = array();
        if(empty($searchString)){
            foreach (fund::all() as $fund)
                array_push($res, $fund->id);
            return $res;
        }
        $searchText = '%'.$searchString.'%';
        $funds = fund::where('name', 'like', $searchText)
                       ->orWhere('duration', 'like', $searchText)
                       ->orWhere('financial', 'like', $searchText)
                       ->orWhere('deadline', 'like', $searchText)
                       ->orWhere('farsi', 'like', $searchText)
                       ->orWhere('memo', 'like', $searchText)
                       ->orWhere('comments', 'like', $searchText)
                       ->orWhere('description', 'like', $searchText)
                       ->get();
        foreach ($funds as $fund)
                array_push($res, $fund->id);
        return $res;
    }


}
