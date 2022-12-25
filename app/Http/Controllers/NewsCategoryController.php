<?php

namespace App\Http\Controllers;

use App\DataTables\NewsCategoriesDataTable;
use App\Models\News;
use App\Models\NewsCategories;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NewsCategoriesDataTable $dataTable)
    {
        $data = NewsCategories::orderBy('id', 'DESC')->get();
        return view('pages.news_category.dataTable',[
            'data' => $data
        ]);

    }

    public function getNewsCategory(Request $request)
    {
        // return $dataTable->render('pages.news_category.dataTable');
        if ($request->ajax()) {
            $data = NewsCategories::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="d-flex justify-content-between"><a href="'.route('news-category.edit', $row->id).'" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="javascript:void(0)" onclick="deleteThis(event)" class="delete btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a></div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.news_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->only(['category', 'description']);

        $request->validate([
          'category' => 'required',
          'description' => 'required',
        ]);

        NewsCategories::create($validate);

        return redirect()->route('news-category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = NewsCategories::find($id);

        return view('pages.news_category.edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->only(['category', 'description']);

        $request->validate([
          'category' => 'required',
          'description' => 'required',
        ]);

        $category = NewsCategories::find($id);
        $category->update($validate);

        return redirect()->route('news-category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = NewsCategories::find($id);

        if ($category) {
            $category->delete();
            return $this->success('delete data successfull', $category);
        }
        return $this->failure('delete data failed');
        // return redirect()->route('news-category.index');
    }
}
