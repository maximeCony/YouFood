(function() {

    FormUserManager = function() {

        return {
                    
            init : function() {
                        
                $("#user_groups").change(this.showHideRestaurant);
                $("#yf_addUser").click(this.showHideRestaurant);
            },

            showHideRestaurant : function() {
                        
                //if they choose Administrator
                if($("#user_groups").val() == 3) {
                    $("#user_restaurant").parent().hide().val(0);
                }
                else $("#user_restaurant").parent().show();
            }
        }
    };

}());