<?php

namespace App\Http\Controllers\api\v1\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ShipController extends Controller
{

    private $facets = ['type','name','dob','age','place_of_birth','home_address',
    'name_of_ship','ship_port','date_leaving','joined_ship_date','joined_at_port',
    'capacity','date_left','left_port','cause_of_leaving','sign_with_mark'];


        // $facet = '&facet=true&facet.sort=count&facet.limit=1&facet.mincount=1';
        // foreach($this->facets as $f) {
        //     $facet .= '&facet.field='.$f;
        // }


    /**
     * Display a listing of the resource.
     *
     * @return Response json
     */
    public function getShips()
    {
        $char = \Input::get('char');
        $url = \Config::get('app.url') . \Config::get('app.solr');

        $json = file_get_contents($url.'select?q=vessel_name_fixed:'.$char.'*&wt=json&indent=true&group=true&group.field=ship_official_number&sort=vessel_name%20asc&rows=900');

        $data = json_decode($json,TRUE);

        $result = [];

        $result['total_log_books'] = $data['grouped']['ship_official_number']['matches'];

        $result['total_ships'] = count($data['grouped']['ship_official_number']['groups']);

        foreach($data['grouped']['ship_official_number']['groups'] as $g) {

            $result['data'][] = [
                'vessel_name' => $g['doclist']['docs'][0]['vessel_name'],
                'id' => $g['doclist']['docs'][0]['ship_official_number'],
                'num_log_books' => $g['doclist']['numFound']
            ];
         }

         return \Response::json($result); 
    }

    /**
     * [getLogBook description]
     * @return [type] [description]
     */
    public function getShipLogBook()
    {
        $id = \Input::get('id');

        $url = \Config::get('app.url') . \Config::get('app.solr');

        $json = file_get_contents($url.'select?q=ship_official_number%3A"'.$id.'"&wt=json&indent=true&rows=900');

        $data = json_decode($json,TRUE);

        $result = [];

        $result['total_log_books'] = $data['response']['numFound'];
        $result['vessel_name'] = $data['response']['docs'][0]['vessel_name'];

        foreach($data['response']['docs'] as $d) {
            $result['data'][] = [
                'id' => $d['id'],
                'vessel_name' => $d['vessel_name'],
                'ship_official_number' => $d['ship_official_number'],
                'port_of_registry' => $d['port_of_registry']
            ];
        }

        return \Response::json($result);
    }

    /**
     * [getLogBook description]
     * @return [type] [description]
     */
    public function getLogBook()
    {
        $id = \Input::get('id');

        $result = [];

        $url = \Config::get('app.url') . \Config::get('app.solr');

        $shipJson = file_get_contents($url.'select?q=id%3A"'.$id.'"&wt=json&indent=true&rows=900');

        $ship = json_decode($shipJson,TRUE);

        $result['ship'] = [
            'id' => $ship['response']['docs'][0]['id'],
            'vessel_name' => $ship['response']['docs'][0]['vessel_name'],
            'ship_official_number' => $ship['response']['docs'][0]['ship_official_number'],
            'port_of_registry' => $ship['response']['docs'][0]['port_of_registry']
        ];

        $crewJson = file_get_contents($url.'select?q=parent%3A"'.$id.'"&wt=json&indent=true');

        $crew = json_decode($crewJson , TRUE);

        foreach($crew['response']['docs'] as $c) {
            $result['crew'][] = [
                'name' => $c['name'],
                'dob' => $c['dob'],
                'age' => $c['age'],
                'place_of_birth' => $c['place_of_birth'],
                'home_address' => $c['home_address'],
                'name_of_ship' => $c['name_of_ship'],
                'ship_port' => $c['ship_port'],
                'date_leaving' => $c['date_leaving'],
                'joined_ship_date' => $c['joined_ship_date'],
                'joined_at_port' => $c['joined_at_port'],
                'capacity' => $c['capacity'],
                'date_left' => $c['date_left'],
                'left_port' => $c['left_port'],
                'cause_of_leaving' => $c['cause_of_leaving'],
                'sign_with_mark' => $c['sign_with_mark'],
                'notes' => $c['notes'],
            ];
        }

        return \Response::json($result);
    }
}
