<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Review;
use App\ReviewStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('status', 'product', 'user')->get();

        return view('admin.reviews.list', ['reviews' => $reviews]);
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);

        $statuses = ReviewStatus::all();

        return view('admin.reviews.edit', ['review' => $review, 'statuses' => $statuses]);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $data = $request->validate([
            'rating' => 'required|numeric',
            'text' => 'required|max:1000',
        ]);

        if ($request->has('status') && ReviewStatus::find($request->input('status')))
            $data['status_id'] = $request->input('status');

        $review->update($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Отзыв успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Review::destroy($id);

        request()->session()->flash('success', 'Отзыв успешно удален!');

        return redirect()->route('admin.reviews.index');
    }
}
