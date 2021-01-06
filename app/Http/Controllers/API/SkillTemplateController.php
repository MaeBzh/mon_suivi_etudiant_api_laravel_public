<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillTemplateRequest;
use App\Http\Resources\SkillTemplateResource;
use App\Models\SkillTemplate;
use App\Repositories\SkillTemplateRepository;
use Auth;
use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SkillTemplateController extends Controller
{
    protected SkillTemplateRepository $skillTemplateRepo;

    public function __construct()
    {
        $this->skillTemplateRepo = new SkillTemplateRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return SkillTemplateResource::collection(SkillTemplate::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SkillTemplateRequest $request)
    {
        $skillTemplate = DB::transaction(function () use ($request) {
            return $this->skillTemplateRepo->prepareStore($request->all(), Auth::user());
        });
        return new SkillTemplateResource($skillTemplate);
    }


    /**
     * Show the specified resource.
     *
     * @param  SkillTemplate $skillTemplate
     * @return SkillTemplateResource
     */
    public function show(SkillTemplate $skillTemplate): SkillTemplateResource
    {
        return new SkillTemplateResource($skillTemplate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SkillTemplate  $skillTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(SkillTemplateRequest $request, SkillTemplate $skillTemplate)
    {
        $skillTemplate = DB::transaction(function () use($request, $skillTemplate) {
            return $this->skillTemplateRepo->setModel($skillTemplate)->prepareUpdate($request->all());
        });
        return new SkillTemplateResource($skillTemplate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SkillTemplate  $skillTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SkillTemplate $skillTemplate)
    {
        return $this->skillTemplateRepo->delete($skillTemplate);
    }
}
