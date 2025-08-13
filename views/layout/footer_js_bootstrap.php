<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  var myCarousel = document.querySelector('#bannerCarousel');
  if (myCarousel && window.bootstrap) {
    new bootstrap.Carousel(myCarousel, {
      interval: 4000,
      ride: 'carousel'
    });
  }
</script>
