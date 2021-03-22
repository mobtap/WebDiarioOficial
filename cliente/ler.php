<!DOCTYPE html>
<html>
  <head>
    <title>PDF.js Learning</title>
  </head>
  <body>
    <script type="text/javascript" src="js/pdf.js"></script>
  </body>
</html>

<script id="script">
  //
  // If absolute URL from the remote server is provided, configure the CORS
  // header on that server.
  //
  var url = './dilee.pdf';

  //
  // The workerSrc property shall be specified.
  //
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'js/pdf.worker.js';

  //
  // Asynchronous download PDF
  //
  var loadingTask = pdfjsLib.getDocument(url);

  loadingTask.promise.then(function(pdf) {
    //
    // Fetch the first page
    //

    // Loop from 1 to total_number_of_pages in PDF document
    for (var i = 1; i <= pdf.numPages; i++) {

        // Get desired page
        pdf.getPage(i).then(function(page) {

      var scale = 1.5;
      var viewport = page.getViewport({ scale: scale, });

      //
      // Prepare canvas using PDF page dimensions
      //
      var canvas = document.getElementById('the-canvas');
      var context = canvas.getContext('2d');
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      //
      // Render PDF page into canvas context
      //
      var renderContext = {
        canvasContext: context,
        viewport: viewport,
      };
      page.render(renderContext);
    	});
  	}
  });
</script>

<hr>

<canvas id="the-canvas"></canvas>
</body>
</html>