// function table(){
// 	           var odiv=document.getElementById("add");
//             var cWidth=document.documentElement.clientWidth;
//           var cHeight=document.documentElement.clientHeight;
//           odiv.style.left=(cWidth-odiv.offsetWidth)/2+'px';
//           odiv.style.top=(cHeight-odiv.offsetHeight)/2+'px';
         
//         return odiv;
             

// }

function xiangqing(){

     document.addEventListener("click",function(evevt){
     var target=event.target;
     if (target.className=="xiangqing") {
      var aa=target.parentNode.parentNode.parentNode.parentNode.parentNode.previousElementSibling;
            aa.click(); 
     }
  })



}
function adelete(){

    document.addEventListener("click",function(event){
    	var target=event.target;
    	if (target.className=="delete") {
    		if(confirm("确认要删除吗?")){
          target.parentNode.parentNode.parentNode.removeChild(target.parentNode.parentNode);
         }
    	}
    })   
    
}



window.onload=function(){
		var oTab=new Tab();
		 var oTab2=new Tab2();
		 var oTab3=new Tab3();
		 var xiangqingId1="yingting";
		 var  xiangqingId2="piaowu";
		
   //        xiugai();
        

  
         var odiv1=document.getElementsByClassName("add")[0];
          var odiv2=document.getElementsByClassName("add")[1];
           var odiv3=document.getElementsByClassName("add")[2];
            var odiv4=document.getElementsByClassName("add")[3];
             var odiv5=document.getElementsByClassName("add")[4];
        var  button1=document.getElementsByName("add")[0];
         var  button2=document.getElementsByName("add")[1];
         var  button3=document.getElementsByName("add")[2];
          var  button4=document.getElementsByName("add")[3];
           var  button5=document.getElementsByName("add")[4];
            
           add(odiv1,button1);
             add(odiv2,button2);
               add(odiv3,button3);
                 add(odiv4,button4);
                   add(odiv5,button5);


         var odiv6=document.getElementsByClassName("xiugai_b")[0];
          var odiv7=document.getElementsByClassName("xiugai_b")[1];
           var odiv8=document.getElementsByClassName("xiugai_b")[2];
            var odiv9=document.getElementsByClassName("xiugai_b")[3];
             var odiv10=document.getElementsByClassName("xiugai_b")[4];
        var  button6=document.getElementsByClassName("xiugai")[0];
         var  button7=document.getElementsByClassName("xiugai")[1];
         var  button8=document.getElementsByClassName("xiugai")[2];
          var  button9=document.getElementsByClassName("xiugai")[3];
           var  button10=document.getElementsByClassName("xiugai")[4];
             add(odiv6,button6);
              add(odiv7,button7);
               add(odiv8,button8);
                 add(odiv9,button9);
                   add(odiv10,button10);
            
                   //删除
                    adelete(); 
                    // 详情    
                    xiangqing();


}
function add(a1,a2,index){
    
    a2.onclick=function(){
      a1.style.display="block";
    }
   var saveButton=a1.getElementsByClassName("addsave")[0];
    var closedButton=a1.getElementsByClassName("closed")[0];
     saveButton.onclick=function(){
    a1.style.display="none";
    // return false;
   }
   closedButton.onclick=function(){
    a1.style.display="none";
   }

}
   
	function Tab(){
		this.adiv=document.getElementsByTagName("article");
		this.ali=document.getElementsByTagName("li");
		var _this=this;
		for (var i = 0; i <this.ali.length; i++) {
			this.ali[i].index=i;
			this.ali[i].onclick=function(){
				_this.change(this);
			}
		}
	}
Tab.prototype.change=function(obj){
  for (var i = 0; i < this.ali.length; i++) {
  	this.adiv[i].style.display="none";
  	this.ali[i].className="";
  }
    this.adiv[obj.index].style.display="block"; 
     this.ali[obj.index].className="active"; 
}
function Tab2(){
	this.adiv=document.getElementsByClassName("switch");
	this.aa=document.getElementById("yingting").getElementsByTagName("a");
	var _this=this;
	for (var i = 0; i < this.aa.length; i++) {
		this.aa[i].index=i;
		this.aa[i].onclick=function(){
			
			_this.change(this);
		}
	}
}
Tab2.prototype.change=function(obj){
	for (var i = 0; i < this.aa.length; i++) {
		this.adiv[i].style.display="none";
		this.aa[i].className="";
	}
	this.adiv[obj.index].style.display="block";
    this.aa[obj.index].className="active";
}
function Tab3(){
	this.adiv=document.getElementsByClassName("switch2");
	this.aa=document.getElementById("piaowu").getElementsByTagName("a");
	var _this=this;
	for (var i = 0; i < this.aa.length; i++) {
		this.aa[i].index=i;
		this.aa[i].onclick=function(){
			
			_this.change(this);
		}
	}
}
Tab3.prototype.change=function(obj){
	for (var i = 0; i < this.aa.length; i++) {
		this.adiv[i].style.display="none";
		this.aa[i].className="";
	}
	this.adiv[obj.index].style.display="block";
    this.aa[obj.index].className="active";
}
  