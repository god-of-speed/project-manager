       var checkMe = function(e){
           $('.dbc').empty();
           $('.btnNav').removeClass('btnActive');
           $('.btnSubNav').removeClass('btnActive');
           var e1= e.target;
           if($(e1).next().is(":visible")){
               $(e1).next().fadeOut(200);
           }else{
           $(e1).addClass('btnActive');
           var id = $(e1).attr('id');
           if(id === 'staff'){
               $('.subStaff').fadeIn(200);
           }else if(id === 'team'){
               $('.subTeam').fadeIn(200);
           }else if(id === 'project'){
                $('.subProject').fadeIn(200);
           }else if(id === 'milestone'){
                 $('.subMilestone').fadeIn(200);
           }else if(id === 'task'){
               $('.subTask').fadeIn(200);
           }else if(id === 'prospect'){
               $('.subProspect').fadeIn(200);
           }else if(id === 'properties'){
               $('.subProperties').fadeIn(200);
           }else if(id === 'inspection'){
               $('.subInspection').fadeIn(200);
           }
           }
       };
         var hitMe = function(e){
             $('.btnNav').removeClass('btnActive');
             $('.btnSubNav').removeClass('btnActive');
             $('.dbc').empty();
             var e1= e.target;
             $('.dbc').hide();
             $(e1).addClass('btnActive');
             var id = $(e1).attr('id');
             if(id === 'subStaff1'){
                 window.location.href='/current-staff';
           }else if(id == 'subStaff2'){
               window.location.href = '/current-staff-form';
           }else if(id == 'subTeam1'){

               var url = '/current-team';
               $.ajax({
                  type:'GET',
                  url:url,
                  dataType:'json',
                  success:function(data){
                      var arr= [];
                    for(var i=0; i<data.length; i++){
                        arr.push({id:data[i][0],name:data[i][1]});
                    }
                    for(var i=0; i<arr.length; i++){
                        $('<a>',{
                             class:'littleBtn',
                             href:'/current-team/'+arr[i].id,
                             role:'button',
                             text:arr[i].name
                    }).appendTo($('.dbc'));
                    }
                    var pos= $(e1).position();
                    $('.dbc').css({"margin-top":pos.top});
                    $('.dbc').fadeIn(200);
                      }
               });
           }else if(id == 'subTeam2'){
                 window.location.href = '/current-team-form';
           }else if(id == 'subProject1'){
               var url = '/current-project';
               $.ajax({
                   type:'GET',
                   url:url,
                   dataType:'json',
                   success:function(data){
                       var arr= [];
                    for(var i=0; i<data.length; i++){
                        arr.push({id:data[i][0],name:data[i][1]});
                    }
                    for(var i=0; i<arr.length; i++){
                        $('<a>',{
                             class:'littleBtn',
                             href:'/current-project/'+arr[i].id,
                             text:arr[i].name
                    }).appendTo($('.dbc'));
                    }
                    var pos= $(e1).position();
                    $('.dbc').css({"margin-top":pos.top});
                    $('.dbc').fadeIn(200);
                   }
               });
           }else if(id == 'subProject2'){
                window.location.href = '/current-project-form';
           }else if(id == 'subMilestone1'){
               var url= '/current-milestone';
               $.ajax({
                   type:'GET',
                   url:url,
                   dataType:'json',
                   success:function(data){
                       var arr= [];
                    for(var i=0; i<data.length; i++){
                        arr.push({id:data[i][0],name:data[i][1]});
                    }
                    for(var i=0; i<arr.length; i++){
                        $('<a>',{
                             class:'littleBtn',
                             href:'/current-milestone/'+arr[i].id,
                             text:arr[i].name
                    }).appendTo($('.dbc'));
                    }
                    var pos= $(e1).position();
                    $('.dbc').css({"margin-top":pos.top});
                    $('.dbc').fadeIn(200);
                   }
               });
           }else if(id == 'subMilestone2'){
               window.location.href = '/current-milestone-form';
           }else if(id == 'subTask1'){
               var url= '/current-task';
               $.ajax({
                   type:'GET',
                   url:url,
                   dataType:'json',
                   success:function(data){
                       var arr= [];
                    for(var i=0; i<data.length; i++){
                        arr.push({id:data[i][0],name:data[i][1]});
                    }
                    for(var i=0; i<arr.length; i++){
                        $('<a>',{
                             class:'littleBtn',
                             href:'/current-task/'+arr[i].id,
                             text:arr[i].name
                    }).appendTo($('.dbc'));
                    }
                    var pos= $(e1).position();
                    $('.dbc').css({"margin-top":pos.top});
                    $('.dbc').fadeIn(200);
                   }
               });
           }else if(id == 'subTask2'){
               window.location.href = '/current-task-form';
           }else if(id === 'subProspect1'){
                 window.location.href='/current-prospect';
           }else if(id == 'subProspect2'){
               window.location.href = '/current-prospect-form';
           }else if(id === 'subProperties1'){
                 window.location.href='/current-properties';
           }else if(id == 'subProperties2'){
               window.location.href = '/current-properties-form';
         }else if(id == 'subInspection1'){
             window.location.href = '/current-inspection';
         }

         }

         var delMe = function(e){
             var e1 = e.target;
             var hf= $(e1).attr('href');
             if(confirm('Are you sure you want to delete this item?')){
               window.location.href = hf;
             }else{
               location.reload();
             }
         }

        
      $(document).ready(function(){
          $('.btnNav').on('click',function(e){
              checkMe(e);
          });
          $('.btnSubNav').on('click', function(e){
              hitMe(e);
          });
            $('#teamId').hide();
            $('.del').on('click',function(e){
                e.preventDefault();
                delMe(e);
            });
          
      });