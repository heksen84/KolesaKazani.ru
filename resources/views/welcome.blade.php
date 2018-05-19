<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="get numbers, free numbers" />
  <meta name="description" content="Доска объявлений АксуМаркет">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Доска объявлений АксуМаркет</title>
  <link rel="icon" href="{{ asset('public/shop.ico') }}">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body>
<div id="app">
<welcome></welcome>


<div class="jumbotron">
    <div class="container">
      <div class="row">
        <div class="col-12 center">
          <div class="img img-logo center"></div>
          <h1>Simple Grid is a CSS grid for your website.</h1>
          <h2 class="font-light">Responsive, light, simple.</h2>
          <a href="simple-grid.zip" download>
            <button>Download</button>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-2 hidden-sm"></div>
        <div class="col-8">
          <div class="img img-website-mock"></div>
        </div>
        <div class="col-2 hidden-sm"></div>
      </div>
    </div>
  </div>
  <div class="body-content">
    <div class="container">
      <div class="row">
        <div class="col-4 center">
          <div class="img img-responsive center"></div>
          <h3>Responsive</h3>
          <p>
            Your website will display beautifully, no matter the device or screen type.
          </p>
        </div>
        <div class="col-4 center">
          <div class="img img-lightweight center"></div>
          <h3>Lightweight</h3>
          <p>
            The CSS is super light, so you won’t have to worry about adding to page load times.
          </p>
        </div>
        <div class="col-4 center">
          <div class="img img-simple center"></div>
          <h3>Simple</h3>
          <p>
            Simple Grid is made for all skill levels, so you can jump right into your project.
          </p>
        </div>
      </div>
      <div class="row">
        <div class="col-4 hidden-sm"></div>
        <div class="col-4">
          <div class="line"></div>
        </div>
        <div class="col-4 hidden-sm"></div>
      </div>
      <div class="row">
        <div class="col-2 hidden-sm"></div>
        <div class="col-8">
          <h3 class="center m-bottom">Simple Grid</h3>
          <p>
            Simple Grid is a 12-column, lightweight CSS grid to help you quickly build responsive websites. Download the CSS stylesheet, add the appropriate classes to your markup, and you're off to the races. It’s that simple.
          </p>
          <p>
            Each column is contained within rows, which are contained within a container. The container is set to a maximum width of 960px, but you can edit without having to break anything.
          </p>
        </div>
        <div class="col-2 hidden-sm"></div>
      </div>
      <div class="grid-display">
        <div class="row">
          <div class="col-1">
            <p>
              one
            </p>
          </div>
          <div class="col-11">
            <p>
              eleven
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-2">
            <p>
              two
            </p>
          </div>
          <div class="col-10">
            <p>
              ten
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <p>
              three
            </p>
          </div>
          <div class="col-9">
            <p>
              nine
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <p>
              four
            </p>
          </div>
          <div class="col-8">
            <p>
              eight
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-5">
            <p>
              five
            </p>
          </div>
          <div class="col-7">
            <p>
              seven
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <p>
              six
            </p>
          </div>
          <div class="col-6">
            <p>
              six
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <p>
              twelve
            </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4 hidden-sm"></div>
        <div class="col-4">
          <div class="line"></div>
        </div>
        <div class="col-4 hidden-sm"></div>
      </div>
      <div class="row">
        <div class="col-2 hidden-sm"></div>
        <div class="col-8">
          <h3 class="center m-bottom">Simple Code</h3>
          <p>
            All the code you need is simple and familiar. Simply state the number of columns you want your content to occupy in the .col class. For example, if you want your content to take up 8 columns (out of 12), simply give your content the class .col-8.
          </p>
          <p>
            Simple grid is built mobile-first, so all columns will expand to the full container width on smaller screens. If you don’t want columns to expand on mobile devices and small screens, simply add -sm to the end of your column class name. For example, if you want to have two blocks of content floating side-by-side on small screens, each would be given the class name .col-6-sm.
          </p>
          <p>
            Be sure to nest columns within a .row class. You may also choose to nest rows within a .container class.
          </p>
          <p>
            The download package now contains an SCSS file for those who prefer SASS as well.
          </p>
        </div>
        <div class="col-2 hidden-sm"></div>
      </div>
      <div class="row">
        <div class="col-12">
          <pre>
            <code>
    <span class="tag">&lt;</span><span class="el">div</span> <span class="name">class</span><span class="tag">=</span><span class="content">"container"</span><span class="tag">&gt;</span>
      <span class="tag">&lt;</span><span class="el">div</span> <span class="name">class</span><span class="tag">=</span><span class="content">"row"</span><span class="tag">&gt;</span>
        <span class="tag">&lt;</span><span class="el">div</span> <span class="name">class</span><span class="tag">=</span><span class="content">"col-3"</span><span class="tag">&gt;</span>
          <span class="comment">&lt;!-- This content will take up 3/12 (or 1/4) of the container --&gt;</span>
        <span class="tag">&lt;/</span><span class="el">div</span><span class="tag">&gt;</span>
        <span class="tag">&lt;</span><span class="el">div</span> <span class="name">class</span><span class="tag">=</span><span class="content">"col-3"</span><span class="tag">&gt;</span>
          <span class="comment">&lt;!-- This content will take up 3/12 (or 1/4) of the container --&gt;</span>
        <span class="tag">&lt;/</span><span class="el">div</span><span class="tag">&gt;</span>
        <span class="tag">&lt;</span><span class="el">div</span> <span class="name">class</span><span class="tag">=</span><span class="content">"col-6"</span><span class="tag">&gt;</span>
          <span class="comment">&lt;!-- This content will take up 6/12 (or 1/2) of the container --&gt;</span>
        <span class="tag">&lt;/</span><span class="el">div</span><span class="tag">&gt;</span>
      <span class="tag">&lt;/</span><span class="el">div</span><span class="tag">&gt;</span>
    <span class="tag">&lt;/</span><span class="el">div</span><span class="tag">&gt;</span></code>
          </pre>
        </div>
      </div>
      <div class="row">
        <div class="col-4 hidden-sm"></div>
        <div class="col-4">
          <div class="line"></div>
        </div>
        <div class="col-4 hidden-sm"></div>
      </div>
      <div class="row">
        <div class="col-2 hidden-sm"></div>
        <div class="col-8">
          <h3 class="center m-bottom">Simple Typography</h3>
          <p>
            Simple Grid uses Lato from Google Fonts as a base font-family. Font-size is based on root rem units.
          </p>
          <h1>Header 1</h1>
          <h2>Header 2</h2>
          <h3>Header 3</h3>
          <h4>Header 4</h4>
          <h5>Header 5</h5>
          <h6>Header 6</h6>
          <p>
            Additionally, should you choose to style any of the headers or paragraph font-weights, simply add the class .font-light, <span class="font-regular">.font-regular</span>, or <span class="font-heavy">.font-heavy</span> to your markup. Paragraph text is set by default to a font-weight of 200. Note: the .font-heavy class should not be used as a replacement for semantic bold body copy.
          </p>
        </div>
        <div class="col-2 hidden-sm"></div>
      </div>
      <div class="row">
        <div class="col-4 hidden-sm"></div>
        <div class="col-4">
          <div class="line"></div>
        </div>
        <div class="col-4 hidden-sm"></div>
      </div>
      <div class="row">
        <div class="col-12 center">
          <h2 class="red">Start Building</h2>
          <a href="simple-grid.zip" download>
            <button class="btn-secondary">Download</button>
          </a>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="img img-logo"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <p>Simple Grid<br/>
          Made by <a href="http://zcole.me" target="_blank">Zach Cole</a><br/>
          Contribute on <a href="https://github.com/zachacole/Simple-Grid" target="_blank">Github</a><br/>
          Share on <a href="https://twitter.com/intent/tweet?text=Simple%20Grid%3A%20A%20css%20grid%20for%20your%20website%3A%20http%3A%2F%2Fsimplegrid.io%2F%20by%20%40zachacole&source=webclient" target="_blank">Twitter</a></p>
          <p>
            Open source under the <a href="https://opensource.org/licenses/MIT" target="_blank">MIT License</a>
          </p>
        </div>
      </div>
    </div>
  </footer>
  
</div>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>
