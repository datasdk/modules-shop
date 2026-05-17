<?php

namespace Modules\Shop\Http\Controllers\Api;

use App\Http\Controllers\OrionBaseController;
use Illuminate\Http\JsonResponse;
use Modules\Shop\Models\Terms;
use Modules\Shop\Http\Requests\TermsRequest;
use Orion\Http\Requests\Request;


class TermsController extends OrionBaseController
{

    protected $model = Terms::class;

    protected $request = TermsRequest::class;


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $term = Terms::create($request->validated());

        return response()->json($term, 201);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ...$args): JsonResponse
    {

        $term = Terms::findOrFail($id);

        $term->update($request->validated());

        return response()->json($term);

    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Request $req, ...$args): JsonResponse
    {
        
        $id = $args[0];

        $term = Terms::findOrFail($id);

        $term->delete();

        return response()->noContent();

    }

}
