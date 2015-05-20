<?php

namespace MatM\Bundle\TypeAheadBundle\Services;

class TypeAheadDataBuilder
{
    public function makeTypeAheadDataset($results, $displayMethod, $searchMethod)
    {
        $list = array();

        foreach ($results as $result) {
            $reflectionClass = new \ReflectionClass(get_class($result));

            if ($reflectionClass->hasMethod($displayMethod) && $reflectionClass->hasMethod($searchMethod)) {
                $list[] = array(
                    "displayed_value" => $result->{$displayMethod}(),
                    "selected_value"  => $result->getId(),
                    "search_value"    => $result->{$searchMethod}()
                );
            } else {
                foreach (array($displayMethod, $searchMethod) as $method) {
                    if (!$reflectionClass->hasMethod($method)) {
                        throw new \Exception("Method ".$method."() was not found in class ".get_class($result));
                    }
                }
            }
        }

        return $list;
    }
}
