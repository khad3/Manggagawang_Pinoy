<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/applicant/editforumpage.css') }}" />
  <title>Edit Post</title>
</head>
<body>
  <div class="container container-custom">
    <div class="post-form">
      <div class="mb-4 text-center">
        <h4 class="form-header"><i class="bi bi-pencil-square"></i> Edit Your Post</h4>
        <p class="text-muted">Make changes to your previous forum post here.</p>
      </div>

      @foreach ($retrievedPosts as $post)
        <form method="POST" action="{{ route('applicant.forum.update', ['id' => $post->id]) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="postTitle" class="form-label"><i class="bi bi-type"></i> Post Title</label>
            <input type="text" class="form-control" id="postTitle" value="{{ $post->title }}" name="post_title" required maxlength="100" />
          </div>

          <div class="mb-3">
            <label for="positionSelect" class="form-label"><i class="bi bi-tags"></i> Select Topic</label>
            <select class="form-select" id="positionSelect" name="post_topic" required>
              <option value="{{ $post->category }}">{{ $post->category }}</option>
              <option value="Automotive Servicing">Automotive Servicing</option>
              <option value="Bartender">Bartender</option>
              <option value="Barista">Barista</option>
              <option value="Beauty Care Specialist">Beauty Care Specialist</option>
              <option value="Carpenter">Carpenter</option>
              <option value="Cook">Cook</option>
              <option value="Customer Service Representative">Customer Service Representative</option>
              <option value="Dressmaker/Tailor">Dressmaker/Tailor</option>
              <option value="Electrician">Electrician</option>
              <option value="Food and Beverage Server">Food and Beverage Server</option>
              <option value="General Clerk">General Clerk</option>
              <option value="General Salesman">General Salesman</option>
              <option value="Hairdresser">Hairdresser</option>
              <option value="Housekeeping">Housekeeping</option>
              <option value="IT/Computer System Servicing">IT/Computer System Servicing</option>
              <option value="Machine Operator">Machine Operator</option>
              <option value="Mason">Mason</option>
              <option value="Mechanical Draftsman">Mechanical Draftsman</option>
              <option value="Plumber">Plumber</option>
              <option value="Receptionist">Receptionist</option>
              <option value="Secretary">Secretary</option>
              <option value="Tailor">Tailor</option>
              <option value="Tourism">Tourism</option>
            </select>
          </div>

          @if($post->image_path)
            <div class="mb-3 current-media">
              <label class="form-label">Current Media:</label><br>
              @if(Str::endsWith($post->image_path, ['.mp4', '.mov']))
                <video src="{{ asset('storage/' . $post->image_path) }}" controls width="100%" class="rounded"></video>
              @else
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Current Media" class="img-fluid rounded" />
              @endif
            </div>
          @endif

          <div class="mb-3">
            <label for="postMedia" class="form-label"><i class="bi bi-upload"></i> Upload New Photo or Video</label>
            <input type="file" class="form-control" id="postMedia" name="post_media" accept="image/*,video/*" />
          </div>

          <div class="mb-3">
            <label for="postContent" class="form-label"><i class="bi bi-chat-left-text"></i> Post Content</label>
            <textarea class="form-control" id="postContent" name="post_content" rows="5" required maxlength="800">{{ $post->content }}</textarea>
          </div>

          <button type="submit" class="btn btn-success w-100"><i class="bi bi-check-circle"></i> Update Post</button>
        </form>
      @endforeach

      <div class="text-center back-button">
        <a href="{{ route('applicant.forum.display') }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Back to Forum</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
