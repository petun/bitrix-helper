var BasketService = function() {
};

BasketService.prototype = {
    runAjax : function(data, callback) {
        $.ajax({
            data: data,
            dataType: 'json',
            method: 'post',
            url:'/bitrix/templates/elprocom_sites/basket.php',
            success: callback
        })
    },

    addItem: function(id, count, callback) {
        this.runAjax({id:id, count: count, type:'addItem' }, callback);
    },

    addItems: function(data, callback) {
        this.runAjax({data:data, type:'addItems' }, callback);
    },

    removeItem: function(id, callback) {
        this.runAjax({id:id, type:'removeItem'}, callback);
    },

    clear: function(callback) {
        this.runAjax({type:'clear'}, callback);
    },

    info: function(callback) {
        this.runAjax({type:'info'}, callback);
    }
};

