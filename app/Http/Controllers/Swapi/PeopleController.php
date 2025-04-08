<?php

namespace App\Http\Controllers\Swapi;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\People;
use App\Models\Planet;
use App\Models\Species;
use App\Models\Vehicles;
use App\Services\AuditService;
use App\Services\SwapiService;

class PeopleController extends Controller
{
    protected $swapiService;
    protected $auditService;

    public function __construct(SwapiService $swapiService,AuditService $auditService)
    {
        $this->swapiService = $swapiService;
        $this->auditService = $auditService;
    }

    public function list()
    {
        $characters = People::with(['planet', 'films', 'vehicles', 'species'])->get();
        
        $this->auditService->saveQueryLog('list_people','people',null);

        return response()->json([
            'data' => $characters
        ]);
    }

    public function show($id)
    {
        $character = People::with(['planet', 'films', 'vehicles', 'species'])->find($id);

        if (!$character) {
            return response()->json(['message' => 'Personaje no encontrado'], 404);
        }

        $this->auditService->saveQueryLog('show_people','people',$character->id);

        return response()->json(['data' => $character]);
    }

    public function importPeople($id){
        $people = $this->swapiService->getPeople($id);

        $exists = People::with(['planet', 'films', 'vehicles', 'species'])
                            ->where('name', $people['name'])
                            ->first();

        if ($exists) {
            $this->auditService->saveQueryLog('import_people','people_exist',$exists->id);

            return response()->json([
                'message' => 'El personaje ya se encuentra registrado.',
                'data' => $exists
            ], 200);
        }
        
        // PLANETA
        $planetData = $this->swapiService->getSwapiByUrl($people['homeworld']);
        $planet = Planet::firstOrCreate(['name' => $planetData['name']],
        [
            'climate' => $planetData['climate'] ?? null,
            'terrain' => $planetData['terrain'] ?? null,
            'population' => $planetData['population'] ?? null
        ]);

        // PERSONAJE
        $peopleUpdCrt = $this->registerPeople($people,$planet->id);
        
        $this->auditService->saveQueryLog('import_people','people',$peopleUpdCrt->id);

        return response()->json([
            'message' => 'Personaje importado correctamente',
            'people' => $peopleUpdCrt->load('planet', 'films', 'vehicles', 'species')
        ]);
    }

    public function syncSwappiArrayData($var,$people){
        $dataIds = [];
        foreach($people[$var] as $searchUrl){
            $peopleData = $this->swapiService->getSwapiByUrl($searchUrl);
            $data = '';
            switch($var){
                case 'films':
                    $data = Film::firstOrCreate(['title' => $peopleData['title']]);
                break;
                case 'vehicles':
                    $data = Vehicles::firstOrCreate(['name' => $peopleData['name']]);
                break;
                case 'species':
                    $data = Species::firstOrCreate(['name' => $peopleData['name']]);
                break;
            }
            $dataIds[] = $data->id;
        }
        return $dataIds;
    }

    public function registerPeople($people, $planetId){
        $peopleUpdCrt = People::updateOrCreate(
            ['name' => $people['name']],
            ['planet_id' => $planetId]
        );

        // PELÍCULAS
        $peopleUpdCrt->films()->sync($this->syncSwappiArrayData("films",$people));
        // VEHÍCULOS
        $peopleUpdCrt->vehicles()->sync($this->syncSwappiArrayData('vehicles',$people));
        // ESPECIES
        $peopleUpdCrt->species()->sync($this->syncSwappiArrayData('species',$people));

        return $peopleUpdCrt;
    }
}
