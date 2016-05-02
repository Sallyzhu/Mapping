<?php
namespace Mapping\CsvMapping;

use CSVImport\Mapping\AbstractMapping;

class CsvMapping extends AbstractMapping
{
    public static function getLabel()
    {
        return 'Map';
    }
    
    public static function getName()
    {
        return 'mapping-plugin';
    }
    
    public static function getSidebar($view)
    {
        $html = "<div id='mapping-plugin' class='sidebar flags'>
                    <h3>Mapping Info: </h3>
                    <ul>
                        <li data-flag='column-map-lat' data-flag-type='mapping-plugin'>
                            <a href='#' class='button'><span>Latitude</span></a>
                        </li>
                        <li data-flag='column-map-lng' data-flag-type='mapping-plugin'>
                            <a href='#' class='button'><span>Longitude</span></a>
                        </li>
                        <li data-flag='column-map-latlng' data-flag-type='mapping-plugin'>
                            <a href='#' class='button'><span>Latitude/Longitude</span></a>
                        </li>
                    </ul>
                </div>
        ";
        return $html;
    }
    
    public function processRow($row)
    {
        $json = ['o-module-mapping:marker' => []];
        $latMap = isset($this->args['column-map-lat']) ? array_keys($this->args['column-map-lat']) : [];
        $lngMap = isset($this->args['column-map-lng']) ? array_keys($this->args['column-map-lng']) : [];
        $latLngMap = isset($this->args['column-map-latlng']) ? array_keys($this->args['column-map-latlng']) : [];
        
        
        $markerJson = [];
        foreach($row as $index => $value) {
            $value = trim($value);
            
            if(in_array($index, $latMap)) {
                $markerJson['o-module-mapping:lat'] = $value;
            }
            
            if(in_array($index, $lngMap)) {
                $markerJson['o-module-mapping:lng'] = $value;
            }
            
            if(in_array($index, $latLngMap)) {
                $latLng = explode($value, '/');
                $markerJson['o-module-mapping:lat'] = $latLng[0];
                $markerJson['o-module-mapping:lng'] = $latLng[1];
            }
            
        }
        if (isset($markerJson['o-module-mapping:lat']) && isset($markerJson['o-module-mapping:lng'])) {
            $json['o-module-mapping:marker'][] = $markerJson;
            return $json;
        }
        
        return [];
    }
}