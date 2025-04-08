<?php 

namespace App\Http\Controllers\Swapi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planet;
use App\Models\Character;
use App\Models\People;
use App\Services\SwapiService;
use Illuminate\Support\Facades\Http;

class PlanetController extends Controller{

    protected $swapiService;
    protected $swapiPeopleController;

    public function __construct(SwapiService $swapiService,PeopleController $swapiPeopleController )
    {
        $this->swapiService = $swapiService;
        $this->swapiPeopleController = $swapiPeopleController;
    }

    public function list()
    {
        $planets = Planet::with(['people'])->get();

        return response()->json([
            'data' => $planets
        ]);
    }

    public function show($id)
    {
        $planet = Planet::with(['people'])->find($id);

        if (!$planet) {
            return response()->json(['message' => 'Planeta no encontrado'], 404);
        }

        return response()->json([
            'data' => $planet
        ]);
    }

    public function import($id)
    {
        $planets = $this->swapiService->getPlanets($id);
        $exists = Planet::where('name', $planets['name'])
            ->first();

        if ($exists) {
            return response()->json([
                'message' => 'El planeta ya se encuentra registrado.',
                'data' => $exists
            ], 200);
        }

        // Guardar planeta
        $planet = Planet::firstOrCreate(
            ['name' => $planets['name']],
            [
                'climate' => $planets['climate'] ?? null,
                'terrain' => $planets['terrain'] ?? null,
                'population' => $planets['population'] ?? null
            ]
        );

        // Relacionar personajes que lo habitan
        foreach($planets['residents'] as $residentUrl) {
            $residentData = $this->swapiService->getSwapiByUrl($residentUrl);
            $this->swapiPeopleController->registerPeople($residentData,$planet->id);
        }

        return response()->json([
            'message' => 'Planeta importado correctamente',
            'planet' => $planet->load('people')
        ]);
    }
}