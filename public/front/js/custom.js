function get_filter(class_name){
 var filter = [];
 $('.'+class_name+':checked').each(function(){
 filter.push($(this).val());
 });
 return filter;
}