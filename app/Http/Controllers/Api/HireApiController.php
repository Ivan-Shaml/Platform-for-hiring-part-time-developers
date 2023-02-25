<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HireRequest;
use App\Http\Resources\HireResource;
use App\Models\Developer;
use App\Models\Hire;
use App\Services\Contracts\IHireService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class HireApiController extends Controller
{

    private IHireService $hireService;

    /**
     * @param IHireService $hireService
     */
    public function __construct(IHireService $hireService)
    {
        $this->hireService = $hireService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return HireResource::collection($this->hireService->getHire());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(HireRequest $request, Hire $hire)
    {
        $hire_devs_by_names = Developer::where('name', $request->names)->get();
//        $hire_devs_by_names = Hire::with('developer')->get();
        $hire_dev = '';
        foreach ($hire_devs_by_names as $dev) {
            $hire_dev = $hire->create([
//                'developer_id' => $dev->developer->id,
                'developer_id' => $dev->id,
                'names' => request('names'),
                'start_date' => request('start_date'),
                'end_date' => request('end_date'),
            ]);
        }

        return response()->json($hire_dev, ResponseAlias::HTTP_CREATED);
    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function store()
//    {
//
//    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hire  $hire
     * @return \Illuminate\Http\Response
     */
    public function show(Hire $hire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hire  $hire
     * @return \Illuminate\Http\Response
     */
    public function edit(Hire $hire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hire  $hire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hire $hire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $success_delete = $this->hireService->deleteHire($id);

        return ($success_delete ? new Response('', ResponseAlias::HTTP_NO_CONTENT) : new Response('', ResponseAlias::HTTP_NOT_FOUND));
    }
}
