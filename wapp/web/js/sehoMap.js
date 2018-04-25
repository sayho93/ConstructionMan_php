var Map = function(){
    this.map = new Object();
};

Map.prototype = {
    put : function(key, value){
        this.map[key] = value;
    },
    get : function(key){
        return this.map[key];
    },
    containsKey : function(key){
        return key in this.map;
    },
    remove : function(key){
        delete this.map[key];
    }
};