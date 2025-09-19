<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AnnouncementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    
    //Create announcement
    public function createAnnouncement(Request $request) {

        $validation = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string', 
            'priority' => 'required|in:low,medium,high,urgent',
            'audience' => 'required|in:all,applicants,employers,tesda_officers',
            'date' => 'required|date',
            'status' => 'required|in:draft,published,scheduled,archived',
            'image' => 'nullable|image|max:2048', // Optional image, max size 2MB
            'tags' => 'nullable|string|max:50', // Optional tag
        ]);
        

        $Announcement = new AnnouncementModel();
        $Announcement->title = $validation['title'];
        $Announcement->content = $validation['content'];
        $Announcement->priority = $validation['priority'];
        $Announcement->target_audience = $validation['audience'];
        $Announcement->publication_date = $validation['date'];
        $Announcement->status = $validation['status'];
        $Announcement->tag = $validation['tags'] ?? null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public'); 
            // saves to storage/app/public/announcements
            $Announcement->image = $imagePath; // store only the relative path
        }

        $Announcement->save();

        return redirect()->back()->with('success', 'Announcement created successfully.');
    }


    //Delete announcement
    public function deleteAnnouncement($id) {
        $announcement = AnnouncementModel::find($id);
        if ($announcement) {
            $announcement->delete();
            return redirect()->back()->with('success', 'Announcement deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Announcement not found.');
        }
    }

//Update announcement
public function updateAnnouncement(Request $request, $id)
{
    // Validate input
    $validated = $request->validate([
        'title'    => 'required|string|max:255',
        'content'  => 'required|string',
        'priority' => 'required|in:low,medium,high,urgent',
        'target_audience' => 'required|in:all,applicants,employers,tesda_officers',
        'publication_date'     => 'required|date',
        'status'   => 'required|in:draft,published,scheduled,archived',
        'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'tags'     => 'nullable|string|max:255',
    ]);

    // Find announcement
    $announcement = AnnouncementModel::find($id);

    if (!$announcement) {
        return redirect()->back()->with('error', 'Announcement not found.');
    }

    // Update fields
    $announcement->title           = $validated['title'];
    $announcement->content         = $validated['content'];
    $announcement->priority        = $validated['priority'];
    $announcement->target_audience = $validated['target_audience'];
    $announcement->publication_date = $validated['publication_date'];
    $announcement->status          = $validated['status'];
    $announcement->tag             = $validated['tags'] ?? null;

if ($request->hasFile('image')) {
    $file = $request->file('image');
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // Delete old image if exists
    if (!empty($announcement->image) && file_exists(public_path('announcements/' . $announcement->image))) {
        unlink(public_path('announcements/' . $announcement->image));
    }

    // Move to public/announcements
    $file->move(public_path('announcements'), $filename);

    // Save only filename
    $announcement->image = $filename;
}




    $announcement->save();

    return redirect()->back()->with('success', 'Announcement updated successfully.');
}

}
