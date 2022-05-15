<?php

namespace App\Http\Controllers\Tender;

use App\Models\TenderCategory;
use App\Http\Requests\Tender\StoreTenderCategoryRequest;
use App\Http\Requests\Tender\UpdateTenderCategoryRequest;

class TenderCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTenderCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTenderCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TenderCategory  $tenderCategory
     * @return \Illuminate\Http\Response
     */
    public function show(TenderCategory $tenderCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TenderCategory  $tenderCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(TenderCategory $tenderCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTenderCategoryRequest  $request
     * @param  \App\Models\TenderCategory  $tenderCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTenderCategoryRequest $request, TenderCategory $tenderCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TenderCategory  $tenderCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TenderCategory $tenderCategory)
    {
        //
    }
}
