var counter = (function(pubsub){
  "use strict";

  var _count = 0;
  var _counter = document.getElementById("select-counter");
  var _maxPhoto = parseInt(document.getElementById("max-photos").innerHTML);
  pubsub.subscribe("incrementCounter", _incrementCounter.bind(this));
  pubsub.subscribe("photoUnselected", _decrementCounter.bind(this));
  pubsub.subscribe("orderLoaded", _setCount.bind(this));

  function _setCount(c){
    _count = c;
    _counter.innerHTML = _count;
  }
  function _decrementCounter(){
    _count--;
    _counter.innerHTML = _count;
  }
  function _incrementCounter($img){
    if(_count < _maxPhoto){
      _count++;
      _counter.innerHTML = _count;
      pubsub.publish("counterIncremented",$img);
    }
    else{
      alert("Cannot select any more photos.  Max amount has been selected.");
    }
  }
})(pubsub);
