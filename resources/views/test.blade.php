<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laravel Multiple File Upload Example</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
</head>
<body>

    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="post" action="/checkPhotos" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" name="filename[]" class="form-control" multiple>          
        <button type="submit">ОТПРАВИТЬ</button>
    </form>        
    
</body>
</html>