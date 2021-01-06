<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiplomaStoreRequest;
use App\Http\Requests\DiplomaUpdateRequest;
use App\Http\Resources\DiplomaResource;
use App\Models\Diploma;
use App\Models\SkillTemplate;
use App\Repositories\DiplomaRepository;
use App\Repositories\SkillTemplateRepository;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DiplomaController extends Controller
{
    protected DiplomaRepository $diplomaRepo;
    protected SkillTemplateRepository $skillTemplateRepo;

    public function __construct()
    {
        $this->diplomaRepo = new DiplomaRepository();
        $this->skillTemplateRepo = new SkillTemplateRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return DiplomaResource::collection(Diploma::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiplomaStoreRequest $request)
    {
        $diploma = DB::transaction(function () use($request) {
            $skillTemplates = new Collection();

            foreach ($request->skillTemplates as $skillTemplate) {
                $newSkillTemplate =  $this->skillTemplateRepo->setModel(new SkillTemplate())->prepareStore($skillTemplate);
                $skillTemplates->push($newSkillTemplate);
            }

            return $this->diplomaRepo->prepareStore($request->all(), $skillTemplates);
        });


        return new DiplomaResource($diploma);
    }


    /**
     * Show the specified resource.
     *
     * @param  Diploma $diploma
     * @return DiplomaResource
     */
    public function show(Diploma $diploma): DiplomaResource
    {
        return new DiplomaResource($diploma);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Diploma  $diploma
     * @return \Illuminate\Http\Response
     */
    public function update(DiplomaUpdateRequest $request, Diploma $diploma)
    {
        $diploma = DB::transaction(function () use($request, $diploma){
            $skillTemplates = new Collection();
            foreach ($request->skillTemplates as $skillTemplate) {
                if (array_key_exists('id', $skillTemplate)) {
                    $skillTemplates->push($this->skillTemplateRepo->setModel(SkillTemplate::find($skillTemplate['id']))->prepareUpdate($skillTemplate));
                } else {
                    $skillTemplates->push($this->skillTemplateRepo->prepareStore($skillTemplate));
                }
            }

            return $this->diplomaRepo->setModel($diploma)->prepareUpdate($request->all(), $skillTemplates);

        });

        return new DiplomaResource($diploma);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Diploma  $diploma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diploma $diploma)
    {
        return $this->diplomaRepo->delete($diploma);
    }
}
