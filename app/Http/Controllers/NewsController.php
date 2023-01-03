<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = News::orderBy('id', 'DESC')->with('news_categories')->get();

        return view('pages.news.dataTable',[
            'data' => $data
        ]);
    }

    public function getNews(Request $request)
    {
        // return $dataTable->render('pages.news_category.dataTable');
        if ($request->ajax()) {
            $data = News::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('news_category', function($row){
                    $category = $row->news_categories ? $row->news_categories->category : '';
                    return $category;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="d-flex justify-content-between"><a href="'.route('news.edit', $row->id).'" class="edit btn btn-sm btn-success btn-sm">Edit</a>
                    <a href="javascript:void(0)" onclick="deleteThis(event)" class="delete btn btn-sm btn-danger btn-sm" data-id="'.$row->id.'">Delete</a></div>';
                    return $actionBtn;
                })
                ->addColumn('image', function($row){
                    $image = '<img style="width: 50px;height:50px" class="rounded" src="'.$row->image_url.'" alt="">';
                    return $image;
                })
                ->addColumn('slide', function($row){
                    if ($row->slide) {
                        $slide = '<div class="form-check text-center">
                            <input class="form-check-input slide" type="checkbox" onchange="changeSlide(event)" checked  id="'.$row->id.'">
                            <label class="form-check-label" for="flexCheckDefault"> 
                            </label>
                        </div>';
                    }else {
                        $slide = '<div class="form-check text-center">
                            <input class="form-check-input slide" type="checkbox" onchange="changeSlide(event)"  id="'.$row->id.'">
                            <label class="form-check-label" for="flexCheckDefault"> 
                            </label>
                        </div>';
                    }
                    return $slide;
                })
                ->rawColumns(['action', 'news_category', 'image', 'slide'])
                ->make(true);
        }
    }

    public function create()
    {
        $category = NewsCategories::get();
        return view('pages.news.create', [
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->only(['title', 'news_category_id', 'author_by', 'description']);

        $request->validate([
          'title' => 'required',
          'news_category_id' => 'nullable|exists:news_categories,id',
        ]);

        $validate = array_merge($validate, [
           'date_text' => Carbon::now()->format('d F Y'),
           'slug' => Str::slug($request->title),
        ]);

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store(News::IMAGE_PATH, 'local');
            // Storage::disk('public')->put(Equitment::IMAGE.'/'.$imageName, $request->file('image'));

            $filename  = pathinfo($imagePath, PATHINFO_FILENAME);
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            $imageName = $filename . '.' . $extension;

            $validate = array_merge($validate, [
                'image' => $imageName,
            ]);
        }

        News::create($validate);

        return redirect()->route('news.index');
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
        $category = NewsCategories::get();
        $data = News::find($id);

        return view('pages.news.edit', [
            'category' => $category,
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
        $validate = $request->only(['title', 'news_category_id', 'author_by', 'description']);

        $request->validate([
          'title' => 'required',
          'news_category_id' => 'nullable|exists:news_categories,id',
        ]);

        $validate = array_merge($validate, [
           'slug' => Str::slug($request->title),
        ]);

        $news = News::find($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(News::IMAGE_PATH, 'local');

            $file = public_path('/storage/'.News::IMAGE_PATH.$news->image);
            if (file_exists($file) && !empty($news->image)) {
                unlink($file);
            }

            $filename  = pathinfo($imagePath, PATHINFO_FILENAME);
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            $imageName = $filename . '.' . $extension;

            $validate = array_merge($validate, [
                'image' => $imageName,
            ]);
        }

        $news->update($validate);

        return redirect()->route('news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::find($id);

        try {
            if ($news) {
                $file = public_path('/storage/'.News::IMAGE_PATH.$news->image);
                if (file_exists($file) && !empty($news->image)) {
                    unlink($file);
                }
                $news->delete();

                return redirect()->route('news.index');
            }
        } catch (\Throwable $th) {
            return $this->failure($th->getMessage());
        }
    }

    public function slide(Request $request, $id)
    {
        $news = News::find($id);

        try {
            $news->slide = !$news->slide;
            $news->save();

            return $this->success('update slide news successfull', $news);
            
        } catch (\Throwable $th) {
            return $this->failure($th->getMessage());
        }
    }
}
