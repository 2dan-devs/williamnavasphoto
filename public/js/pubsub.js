var pubsub = (function(){
  "use strict";

  var _events = {};
  function subscribe(eventName,fn){
    _events[eventName] = _events[eventName] || [];
    _events[eventName].push(fn);
  }

  function unsubscribe(eventName,fn){
    if(_events[eventName]){
      var length = _events[eventName].length;
      for(var i = 0; i < length; i++){
        if(_events[eventName][i] === fn){
          _events[eventName].splice(i,1);
          break;
        }
      }
    }
  }

  function publish(eventName,data){
    if(_events[eventName]){
      _events[eventName].forEach(function(fn){
        fn(data);
      });
    }
  }

  return {
    subscribe : subscribe,
    unsubscribe : unsubscribe,
    publish : publish
  };
})();
