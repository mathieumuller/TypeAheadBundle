<?php

namespace MatM\Bundle\TypeAheadBundle\Services;

class TypeAheadManager
{
    public function makeTypeAheadDataset($results, $displayedField, $searchField)
    {
        $displayGetter = $this->stringToGetter($displayedField);
        $searchGetter  = $this->stringToGetter($searchField);

        $list = array();

        foreach ($results as $result) {
            $list[] = array(
                "displayed_value" => $result->{$displayGetter}(),
                "selected_value"  => $result->getId(),
                "search_value"    => $result->{$searchGetter}()
            );
        }

        return $list;
    }

    public function stringToGetter($string)
    {
        $toArray = explode("_", $string);
        foreach ($toArray as $idx => $part) {
            $toArray[$idx] = ucfirst($part);
        }

        return "get".join($toArray, "");
    }
}
