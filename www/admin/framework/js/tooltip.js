
function resetForm(myFormId) {
    var myForm = document.getElementById(myFormId);
    
    for (var i = 0 ; i < myForm.elements.length ; i++ ) {
        
        if('submit' != myForm.elements[i].type && 'reset' != myForm.elements[i].type) {
            
            myForm.elements[i].selectedIndex = 0;
            myForm.elements[i].value = '';
            myForm.elements[i].checked = false;
        }
    }
    
    myForm.submit();
}


var obj;
var tagname = new Array('a', 'img', 'address');

var tooltip = {

    init: function(){

        obj = document.createElement('div');
        obj.setAttribute('id', 'tooltip');

        document.body.appendChild(obj);

        window.document.onmousemove = this.move;

        for(var i = 0; i < tagname.length; i++){

            var ancora = document.getElementsByTagName(tagname[i]);

            for(var j = 0; j < ancora.length; j++){

                var a = ancora[j];
                texttitle = a.getAttribute('title');

                if(texttitle){

                    a.setAttribute('sTitle', texttitle);
                    a.removeAttribute('title');

                    a.onmouseover = function(){

                        t = this.getAttribute('sTitle');

                        obj.innerHTML = t;
                        obj.style.display = 'block';

                    };// end function

                    a.onmouseout = function(){

                        obj.innerHTML = '';
                        obj.style.display = 'none';

                    };// end function

                }//end if

            }//end for

        }//end for

    },

    move: function(e){

        e = e || window.event;

        if(e.pageX || e.pageY){

            x = e.pageX;
            y = e.pageY;

        }else{

            x = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
            y = e.clientY + (document.documentElement.scrollTop ||  document.body.scrollTop) -  document.documentElement.clientTop;

        }//end if

        obj.style.left = (x+5)+'px';
        obj.style.top = (y-35)+'px';
        obj.style.position = 'absolute';

        return true;

    }

}