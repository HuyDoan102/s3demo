<form action="{{ route('multiUpload') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" name="profile_image" id="exampleInputFile" multiple>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
