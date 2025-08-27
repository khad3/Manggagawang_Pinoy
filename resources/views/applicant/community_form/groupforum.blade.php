<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Group Community Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2 class="form-title">Create Community Group</h2>

        <form action="{{ route('applicant.forum.group.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="group_name" class="form-label">Group Name</label>
                <input type="text" class="form-control" id="group_name" name="group_title"
                    placeholder="Enter group name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="group_description" rows="4"
                    placeholder="Write a brief group description..." required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Visibility</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="group_privacy" id="public" value="Public"
                        checked>
                    <label class="form-check-label" for="public">Public</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="group_privacy" id="private" value="Private">
                    <label class="form-check-label" for="private">Private</label>
                </div>
            </div>

            <!-- Hidden field if needed for logged-in applicant -->
            <input type="hidden" name="applicant_id" value="123">

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Create Group</button>
            </div>
        </form>


    </div>

    <!-- back button--->
    <center>
        <div class = "viewmypost">

            <a href="{{ route('applicant.forum.display') }}" class="btn btn-primary">Back to homepage community
                forum</a>


        </div>
    </center>
</body>

</html>
