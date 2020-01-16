<template>
  <div id="calendarPage">
    <input type="button" value="Get Code" @click="getCode" class="testBtn">
    <input type="button" value="Get Token" @click="getToken" class="testBtn">
    <input type="button" value="Get List" @click="getList" class="testBtn">
    <input type="button" value="Add Event" @click="addEvent" class="testBtn">
    <full-calendar
      v-if="isRouterAlive"
      :events='data'
      :config='config'
      @eventClick="eventClick"
      @dayClick="dayClick"
      @moreClick="moreClick"></full-calendar>
    <div id="add" v-show="isAdd">
      <h3>Add Event</h3>
      <span class="cancel" @click="cancel">X</span>
      <div>
         <span>Title:</span>
         <input type="text" class="title" v-model="addData.title">
      </div>
      <div>
        <span>Start:</span>
        <input type="date" class="startD" v-model="addData.start">
        <input type="time" class="startT" v-model="addData.startTime">
      </div>
      <div>
        <span>End:</span>
        <input type="date" class="endD" v-model="addData.end">
        <input type="time" class="endT" v-model="addData.endTime">
      </div>
      <div>
        <span>Description:</span>
        <textarea rows="3" cols="50" class="desc" v-model="addData.description"></textarea>
      </div>
      <div>
        <span>Location:</span>
        <select class="loca" v-model="addData.timeZone">
          <option value="America/Los_Angeles">US</option>
          <option value="Asia/Hong_Kong">CHN</option>
        </select>
      </div>
      <button id="upload" @click="uploadEvent">Submit</button>
      <button @click="cancel()">Cancel</button>
    </div>
    <div class="dayEvent" v-show="isList">
      <span class="cancel" @click="cancel">X</span>
      <ul>
        <li v-for="(event,index) in dayEvent" :key="index" @click="selectEvent(index)">
          {{event.title}}
        </li>
      </ul>
      <div class="showData" v-if="eventPage">
        <div>
          <span>Title:</span>
          <span>{{dayEvent[eventSelected-1].title}}</span>
        </div>
        <div>
          <span>Start:</span>
          <span>{{dayEvent[eventSelected-1].start}} {{dayEvent[eventSelected-1].startTime}}</span>
        </div>
        <div>
          <span>End:</span>
          <span>{{dayEvent[eventSelected-1].end}} {{dayEvent[eventSelected-1].endTime}}</span>
        </div>
        <div>
          <span>Description:</span>
          <span>{{dayEvent[eventSelected-1].description}}</span>
        </div>
        <!-- <div>
          <span>Location:</span>
        </div> -->
        <button id="upload" @click="editEvent">Edit</button>
        <button @click="deleteEvent">Delete</button>
      </div>
      <div v-if="deleteItem" class="deleteBox">
        <h4>Are you sure to delete {{dayEvent[eventSelected-1].title}}?</h4>
        <button @click="deleteEvent(eventSelected-1)">Yes</button>
        <button @click="closeDelete">No</button>
      </div>
      <div class="editData" v-if="editOn">
        <div>
          <span>Title:</span>
          <input type="text" class="title" :placeholder="dayEvent[eventSelected-1].title" v-model="editData.title">
        </div>
        <div>
          <span>Start:</span>
          <input type="date" class="startD" :placeholder="dayEvent[eventSelected-1].start" v-model="editData.start">
          <input type="time" class="startT" :placeholder="dayEvent[eventSelected-1].startTime" v-model="editData.startTime">
        </div>
        <div>
          <span>End:</span>
          <input type="date" class="endD" :placeholder="dayEvent[eventSelected-1].end" v-model="editData.end">
          <input type="time" class="endT" :placeholder="dayEvent[eventSelected-1].endTime" v-model="editData.endTime">
        </div>
        <div>
          <span>Description:</span>
          <textarea rows="3" cols="50" class="desc" :placeholder="dayEvent[eventSelected-1].description" v-model="editData.description"></textarea>
        </div>
        <div>
          <span>Location:</span>
          <select class="loca" :placeholder="dayEvent[eventSelected-1].timeZone" v-model="editData.timeZone">
            <option value="America/Los_Angeles">US</option>
            <option value="Asia/Hong_Kong">CHN</option>
          </select>
        </div>
        <button id="upload" @click="uploadEdit(eventSelected-1)">Submit</button>
        <button @click="closeEdit">Cancel</button>
      </div>
      <h4 v-show="dayEvent.length==0">No event today</h4>
    </div>
  </div>
</template>

<script>
// import {fullCalendar} from 'vue-fullcalendar'
// import FullCalendar from '../assets/vue-fullcalendar/fullCalendar'
import Vue from 'vue'
// import { settings } from 'cluster'
export default {
  name: 'HelloWorld',
  data () {
    return {
      data: [
        {
          title:'Mumbai Film Week',
          start:'2019-09-01',
          startTime:'00:01',
          endTime:'00:01',
          end:'2019-09-05',
          cssClass:'gold'
        },{
          title:'72 Dragons Shenzhen Art Gallery',
          start:'2019-09-03',
          startTime:'00:01',
          endTime:'00:01',
          end:'2019-09-08',
          cssClass:'gold'
        },{
          title:'72 Dragons Mumbai Arts Festival',
          start:'2019-09-01',
          startTime:'00:01',
          endTime:'00:01',
          end:'2019-09-03',
          cssClass:'gold'
        },{
          title:'New York Film Festival',
          start:'2019-09-10',
          startTime:'00:01',
          endTime:'00:01',
          end:'2019-09-11',
          cssClass:'gold'
        },{
          title:'Brad\'s Birthday',
          start:'2019-09-01',
          startTime:'00:01',
          endTime:'00:01',
          end:'2019-09-01',
          cssClass:'gold'
        },{
          title:'72 Dragons Community Meeting',
          start:'2019-09-09',
          startTime:'00:01',
          endTime:'00:01',
          end:'2019-09-21',
          cssClass:'gold'
        },{
          title:'72 Dragons Soccer Competition',
          start:'2019-09-03',
          startTime:'00:01',
          endTime:'00:01',
          end:'2019-09-04',
          cssClass:'gold'
        },{
          title:'Soccer Game--Employees vs Clients',
          start:'2019-09-04',
          startTime:'00:01',
          endTime:'00:01',
          end:'2019-09-04',
          cssClass:'gold'
        },
      ],
      config:{
        buttonText:{month:"month"},
        defaultView:'week',
        firstDay:'1'
      },
      eventList:[],isRouterAlive:true,
      token:'',isAdd:false,dayEvent:[],isList:false,
      addData:{
        title:'',
        start:'',
        startTime:'',
        end:'',
        endTime:'',
        description:'',
        timeZone:''
      },
      editData:{
        title:'',
        start:'',
        startTime:'',
        end:'',
        endTime:'',
        description:'',
        timeZone:''
      },
      eventSelected:'',eventPage:false,editOn:false,deleteItem:false
    }
  },
  methods:{
    cancel(){
      this.isAdd=false
      this.isList=false
      setTimeout(function(){
        this.eventSelected=0
      },0)
      this.editOn=false
      this.eventPage=false
      this.deleteItem=false
    },
    selectEvent(index){
      this.eventSelected=index+1
      this.eventPage=true
      this.editOn=false
    },
    editEvent(){
      this.editOn=true
      this.eventPage=false
    },
    closeEdit(){
      this.editOn=false
      this.eventPage=true
    },
    deleteEvent(){
      this.deleteItem=true
    },
    closeDelete(){
      this.deleteItem=false
    },
    eventClick (event, jsEvent, pos) {
      // console.log('eventClick', event, jsEvent, pos)
    },
    dayClick (day, jsEvent) {
      // console.log('dayClick', day, jsEvent)
      this.dayEvent=[]
      this.isList=true
      var date=new Date(day).getFullYear()+'-'+(new Date(day).getMonth()+1)+'-'+new Date(day).getDate()
      console.log(day,new Date(this.data[1].start+'T'+this.data[1].startTime),new Date(new Date(new Date().toLocaleDateString()).setDate(day.getDate()+1)))
      for(let i in this.data){
        // console.log('datadate',new Date(this.data[i].start),new Date(this.data[i].end),day)
        if(new Date(this.data[i].start)<=new Date(new Date(new Date().toLocaleDateString()).setDate(day.getDate()+1)) && new Date(this.data[i].end)>=day){
          this.dayEvent.push(this.data[i])
          console.log(i)
        }
      }
      console.log('Events of today',this.dayEvent)
    },
    moreClick (day, events, jsEvent) {
      // console.log('moreCLick', day, events, jsEvent)
      this.$children[0].$children[1].showMore=false
    },
    addEvent(){
      this.isAdd=true
      this.addData={
        title:'',
        start:'',
        startTime:'',
        end:'',
        endTime:'',
        description:'',
        timeZone:''
      }
    },
    uploadEvent(){
      var data={}
        // data={
        //   summary:document.querySelector('.title').value,
        //   start:{
        //     //date:$('.startD').val(),
        //     dateTime:document.querySelector('.startD').value+'T'+$('.startT').val()+':00',
        //     timeZone:$('.loca').val()
        //   },
        //   end:{
        //     //date:$('.endD').val(),
        //     dateTime:$('.endD').val()+'T'+$('.endT').val()+':00',
        //     timeZone:$('.loca').val()
        //   },
        //   description:$('.desc').val(),
        //   //access_token:window.sessionStorage.access_token
        // }
      data={
        summary:this.addData.title,
        start:{
          dateTime:this.addData.start+'T'+this.addData.startTime+':00',
          timeZone:this.addData.timeZone
        },
        end:{
          dateTime:this.addData.end+'T'+this.addData.endTime+':00',
          timeZone:this.addData.timeZone
        },
        description:this.addData.description
      }
      // console.log('add',this.addData,data)
      this.$axios.post('https://www.googleapis.com/calendar/v3/calendars/codyshc@gmail.com/events?alt=json&access_token='+this.token,
        data
      ).then(res=>{
        console.log(res)
        this.getList()
      })
      this.isAdd=false
      this.isList=false
      setTimeout(function(){
        this.eventSelected=0
      },0)
      this.editOn=false
      this.eventPage=false
    },
    uploadEdit(index){
      var data={}
      data={
        summary:this.editData.title,
        start:{
          dateTime:this.editData.start+'T'+this.editData.startTime,
          timeZone:this.editData.timeZone
        },
        end:{
          dateTime:this.editData.end+'T'+this.editData.endTime,
          timeZone:this.editData.timeZone
        },
        description:this.editData.description
      }
      this.$axios.put('https://www.googleapis.com/calendar/v3/calendars/codyshc@gmail.com/events/'+this.dayEvent[index].id+'?alt=json&access_token='+this.token,
        data
      ).then(res=>{
        console.log(res)
      })
      this.isAdd=false
      this.isList=false
      setTimeout(function(){
        this.eventSelected=0
      },0)
      this.editOn=false
      this.eventPage=false
    },
    deleteEvent(index){
      console.log(this.dayEvent[index].id)
    },
    getCode(){
      console.log('getting code ...')
      this.$axios.get('https://accounts.google.com/o/oauth2/v2/auth',{
        params:{
          scope: "https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/calendar.events https://www.googleapis.com/auth/calendar.settings.readonly",
          response_type:'code',
          redirect_uri:'http://localhost',
          client_id:'27675862201-qgk4tq3otjqjkuhalk67bcvbroecvptn.apps.googleusercontent.com',
          code_challenge:'musicplay',
          code_challenge_method:'plain',
          state:'security_token%3D138r5719ru3e1%26url%3Dhttps://oauth2.example.com/token',
          access_type:'offline',
          prompt:'consent'
        }
      }).then(res=>{
        console.log(res)
      })
    },
    getToken(){
      console.log('getting token ...')
      this.$axios.post('https://accounts.google.com/o/oauth2/token',{
        code:"4/sAHxumygwjzMunGoF84bQrbcbLlnlwv3iBwNxhaB2kgJmOUuW1cgcCR10WbvY9gfS5ZYd4W8FBjuwrEbi75HEIA",
        redirect_uri:'http://localhost',
        grant_type:'authorization_code',
        client_id:'27675862201-qgk4tq3otjqjkuhalk67bcvbroecvptn.apps.googleusercontent.com',
        client_secret:"JN66id-oKDPHf04BJe4Z8g9f",
        code_verifier:'musicplay',
        scope: "https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/calendar.events https://www.googleapis.com/auth/calendar.settings.readonly"
      }).then(res=>{
        console.log(res)
        this.token=res.data.access_token
        console.log(this.token)
      })
    },
    getList(){
      var thisVue=this
      thisVue.$axios.get('https://www.googleapis.com/calendar/v3/calendars/codyshc@gmail.com/events',{
        params:{
          access_token:this.token
        }
      }).then((res)=>{
        console.log(res)
        thisVue.eventList=res.data.items
        console.log('list:',thisVue.eventList)
        for(let i in thisVue.eventList){
          thisVue.data[i]={}
          if(thisVue.eventList[i].summary){
            // thisVue.data[i]['title']=thisVue.eventList[i].summary
            Vue.set(thisVue.data[i],'title',thisVue.eventList[i].summary)
          }else{
            // thisVue.data[i]['title']='No title'
            Vue.set(thisVue.data[i],'title','No Title')
          }
          if(thisVue.eventList[i].start.date){
            // thisVue.data[i]['start']=thisVue.eventList[i].start.date
            Vue.set(thisVue.data[i],'start',thisVue.eventList[i].start.date)
            // thisVue.data[i]['end']=thisVue.eventList[i].end.date
            Vue.set(thisVue.data[i],'end',thisVue.eventList[i].end.date)
          // }else if(!!thisVue.eventList[i].start.dateTime){
          }else{
            var str=thisVue.eventList[i].start.dateTime
            var ed=thisVue.eventList[i].end.dateTime
            console.log('Data having dateTime',str,str.substr(0,10),ed,ed.substr(0,10))
            // thisVue.data[i]['start']=str.substr(0,10)
            Vue.set(thisVue.data[i],'start',str.substr(0,10))
            // thisVue.data[i]['end']=ed.substr(0,10)
            Vue.set(thisVue.data[i],'end',ed.substr(0,10))            
            // thisVue.data[i]['startTime']=str.substr(11,8)
            Vue.set(thisVue.data[i],'startTime',str.substr(11,8))            
            // thisVue.data[i]['endTime']=ed.substr(11,8)
            Vue.set(thisVue.data[i],'endTime',ed.substr(11,8))            
          }
          if(thisVue.eventList[i].description){
            Vue.set(thisVue.data[i],'description',thisVue.eventList[i].description)
          }
          // thisVue.data[i]['cssClass']='gold'
          Vue.set(thisVue.data[i],'cssClass','gold')            
          // thisVue.data[i]['id']=thisVue.eventList[i].id
          Vue.set(thisVue.data[i],'id',thisVue.eventList[i].id)
        }
        console.log('data:',thisVue.data)
        this.reload()
      })
    },
    reload(){
      this.isRouterAlive=false
      this.$nextTick(function(){
        this.isRouterAlive=true
      })
    },
  },
  components:{
    // 'full-calendar':require('vue-fullcalendar')
    // 'full-calendar':fullCalendar
  },
  mounted(){
    // var btnBlock=document.createElement('div')
    // var newBtn1=document.createElement('input'), newBtn2=document.createElement('input'), newBtn3=document.createElement('input')
    // btnBlock.className='more-footer'    
    // newBtn1.className='addEvent'
    // newBtn1.value='Add'
    // newBtn1.type='button'
    // newBtn2.className='editEvent'
    // newBtn2.value='Edit'
    // newBtn2.type='button'
    // newBtn3.className='cancelEvent'
    // newBtn3.value='Delete'
    // newBtn3.type='button'
    // document.getElementsByClassName('more-events')[0].appendChild(btnBlock)
    // btnBlock.appendChild(newBtn1)
    // btnBlock.appendChild(newBtn2)
    // btnBlock.appendChild(newBtn3)
    // console.log(document.getElementsByClassName('more-events')[0])
  }
}
</script>

