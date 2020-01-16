<template>
  <div id="calendarPage">
    <div id="navBar">
      <!-- <i class="fas fa-bars"></i> -->
      <img src="../assets/72dragonLogo.png" @click="()=>{isNav=!isNav}" />
      <span>72 DRAGONS</span>
    </div>
    <div id="navList" v-show="isNav">
      <ul>
        <li @click="getCode">Login Google Account</li>
        <li @click="addAssignment">Add an Assignment</li>
        <li @click="addEvent">Add an Event</li>
        <li @click="reminder">Set Reminder</li>
        <li @click="addDelete">Calendar List</li>
        <li @click="download">Download</li>
      </ul>
    </div>
    <!-- <input type="button" value="Get Data" @click="getAssignments" class="testBtn" /> -->
    <input type="button" value="Login Google Account" @click="getCode" class="testBtn" />
    <input type="button" value="Add an Assignment" @click="addAssignment" class="testBtn" />
    <input type="button" value="Add Event" @click="addEvent" class="testBtn" />
    <input type="button" value="Set Reminder" @click="reminder" class="testBtn" />
    <input type="button" value="Calendar List" @click="addDelete" class="testBtn" />
    <input type="button" value="Download" @click="download" class="testBtn" />
    <!-- <input type="button" value="test" @click="test" class="testBtn" /> -->
    <full-calendar :events="data" :config="config" @day-click="dayClick" ref="calendar"></full-calendar>
    <!-- <div class="chooseAdd" v-show="showChooseID">
      <span>Add an Event to:</span>
      <select>
        <option value v-for="(owner,index) in ownerID" :key="'c'+index">{{owner.title}}</option>
      </select>
      <button>Confirm</button>
      <button>Cancel</button>
    </div>-->
    <div id="newAssignment" v-show="newAssignment">
      <h3>New Assignment</h3>
      <span class="cancel" @click="cancel">X</span>
      <div>
        <span>Title:</span>
        <input type="text" class="title" v-model="assignmentData.title" />
      </div>
      <div>
        <span>Start:</span>
        <input type="date" class="startD" v-model="assignmentData.start" />
      </div>
      <div>
        <span>End:</span>
        <input type="date" class="endD" v-model="assignmentData.end" />
      </div>
      <div>
        <span>Description:</span>
        <textarea rows="3" cols="50" class="desc" v-model="assignmentData.description"></textarea>
      </div>
      <div>
        <span>Legend:</span>
        <select v-model="assignmentData.legend" @change="selectLegend">
          <option
            :value="item.storyID"
            v-for="(item,index) in legend"
            :key="index+'legned'"
          >{{item.title}}</option>
        </select>
      </div>
      <div>
        <span>Saga:</span>
        <select v-model="assignmentData.saga" @change="selectSaga">
          <option
            :value="item.storyID"
            v-for="(item,index) in saga"
            :key="index+'saga'"
          >{{item.title}}</option>
          <option value="new">New Saga</option>
        </select>
      </div>
      <div v-show="assignmentData.saga=='new'">
        <input type="text" placeholder="Title of a new Saga" v-model="newSaga.title" />
        <textarea rows="3" cols="50" class="desc" v-model="newSaga.description"></textarea>
      </div>
      <div>
        <span>Epic:</span>
        <select v-model="assignmentData.epic" @change="selectEpic">
          <option
            :value="item.storyID"
            v-for="(item,index) in epic"
            :key="index+'epic'"
          >{{item.title}}</option>
          <option value="new">New Epic</option>
        </select>
      </div>
      <div v-show="assignmentData.epic=='new'">
        <input type="text" placeholder="Title of a new Epic" v-model="newEpic.title" />
        <textarea rows="3" cols="50" class="desc" v-model="newEpic.description"></textarea>
      </div>
      <div>
        <span>Story:</span>
        <select v-model="assignmentData.story" @change="selectStory">
          <option
            :value="item.storyID"
            v-for="(item,index) in story"
            :key="index+'story'"
          >{{item.title}}</option>
          <option value="new">New Story</option>
        </select>
      </div>
      <div v-show="assignmentData.story=='new'">
        <input type="text" placeholder="Title of a new Story" v-model="newStory.title" />
        <textarea rows="3" cols="50" class="desc" v-model="newStory.description"></textarea>
      </div>
      <div>
        <span>Story Point:</span>
        <input type="text" v-model="assignmentData.sPoint" />
      </div>
      <div>
        <button @click="uploadAssignment">Submit</button>
        <button @click="cancel">Cancel</button>
      </div>
    </div>
    <div id="add" v-show="isAdd">
      <h3>Add Event</h3>
      <span class="cancel" @click="cancel">X</span>
      <div>
        <span>To:</span>
        <select v-model="addData.calendarID" @change="showNotiAdd">
          <option
            v-for="(owner,index) in ownerID"
            :value="owner.id"
            :key="index+'toO'"
          >{{owner.title}}</option>
          <option v-for="(user,index) in userID" :value="user.id" :key="index+'toU'">{{user.title}}</option>
        </select>
      </div>
      <div>
        <span>Title:</span>
        <input type="text" class="title" v-model="addData.title" />
      </div>
      <div>
        <span>Start:</span>
        <input type="date" class="startD" v-model="addData.start" />
        <input type="time" class="startT" v-model="addData.startTime" />
      </div>
      <div>
        <span>End:</span>
        <input type="date" class="endD" v-model="addData.end" />
        <input type="time" class="endT" v-model="addData.endTime" />
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
      <div v-show="showAddNotif">
        <input type="checkbox" class="checkNotiA" />
        <span class="notiBox">Send Notification</span>
      </div>
      <button id="upload" @click="uploadEvent">Submit</button>
      <button @click="cancel()">Cancel</button>
    </div>
    <div class="dayEvent" v-show="isList">
      <h3>Events on {{selectedDay}}</h3>
      <span class="cancel" @click="cancel">X</span>
      <ul>
        <li
          v-for="(event,index) in dayEvent"
          :key="'a'+index"
          @click="selectEvent(index)"
        >{{event.title}}</li>
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
        </div>-->
        <div v-show="isGoogle">
          <button id="upload" @click="editEvent">Edit</button>
          <button @click="deleteOn">Delete</button>
        </div>
      </div>
      <div v-if="deleteItem" class="deleteBox">
        <h4>Are you sure to delete {{dayEvent[eventSelected-1].title}}?</h4>
        <button @click="deleteEvent(eventSelected-1)">Yes</button>
        <button @click="closeDelete">No</button>
      </div>
      <div class="editData" v-if="editOn">
        <div>
          <span>Title:</span>
          <input
            type="text"
            class="title"
            :placeholder="dayEvent[eventSelected-1].title"
            v-model="editData.title"
          />
        </div>
        <div>
          <span>Start:</span>
          <input
            type="date"
            class="startD"
            :placeholder="dayEvent[eventSelected-1].start"
            v-model="editData.start"
          />
          <input
            type="time"
            class="startT"
            :placeholder="dayEvent[eventSelected-1].startTime"
            v-model="editData.startTime"
          />
        </div>
        <div>
          <span>End:</span>
          <input
            type="date"
            class="endD"
            :placeholder="dayEvent[eventSelected-1].end"
            v-model="editData.end"
          />
          <input
            type="time"
            class="endT"
            :placeholder="dayEvent[eventSelected-1].endTime"
            v-model="editData.endTime"
          />
        </div>
        <div>
          <span>Description:</span>
          <textarea
            rows="3"
            cols="50"
            class="desc"
            :placeholder="dayEvent[eventSelected-1].description"
            v-model="editData.description"
          ></textarea>
        </div>
        <div>
          <span>Location:</span>
          <select
            class="loca"
            :placeholder="dayEvent[eventSelected-1].timeZone"
            v-model="editData.timeZone"
          >
            <option value="America/Los_Angeles">US</option>
            <option value="Asia/Hong_Kong">CHN</option>
          </select>
        </div>
        <div>
          <input type="checkbox" class="checkNotiE" />
          <span class="notiBox">Send Notification</span>
        </div>
        <button id="upload" @click="uploadEdit(eventSelected-1)">Submit</button>
        <button @click="closeEdit">Cancel</button>
      </div>
      <h4 v-show="dayEvent.length==0">No event today</h4>
    </div>
    <div class="reminderList" v-show="showReminder">
      <h4>Set Reminder of:</h4>
      <ul>
        <li v-for="(owner,index) in ownerID" :key="'ro'+index" @click="getReminder(owner.id)">
          <span>{{owner.title}}</span>
        </li>
        <li v-for="(user,index) in userID" :key="'ru'+index" @click="getReminder(user.id)">
          <span>{{user.title}}</span>
        </li>
      </ul>
      <button class="editList" @click="cancel">Close</button>
    </div>
    <div class="reminders" v-if="showReminderDT">
      <h4>Reminders of {{calendarReminderTitle}}</h4>
      <ul>
        <li v-for="(reminder,index) in reminderInfo" :key="'ri'+index">
          <input type="text" v-model="reminder.minutes" />
          <span>Minutes Before Events Start</span>
          <button @click="cancelNewReminder(index)">-</button>
        </li>
      </ul>
      <div>
        <button @click="addNewReminder">+</button>
      </div>
      <div>
        <button class="editList" @click="function(){showReminderDT=!showReminderDT}">Cancel</button>
        <button class="editList" @click="uploadreminders(calendarReminderID)">Confirm</button>
      </div>
    </div>
    <div class="calendarList" v-show="showCalendarList">
      <h4>Calendar List</h4>
      <ul>
        <li v-for="(owner,index) in ownerID" v-show="!showRename[owner.id]" :key="'o'+index">
          <input type="color" v-model="owner.color" @change="changeColor(owner.color,owner.id)" />
          <input type="checkbox" :value="owner.id" @click="addCalendar" class="sCalendar" />
          <span>{{owner.title}}</span>
          <button class="editList" @click="renameCalendar(owner.id)">Rename</button>
          <button class="editList" @click="deleteCalendar(owner.id,owner.title)">Delete</button>
          <button class="editList" @click="shareCalendar(owner.id)">Share</button>
        </li>
        <li v-for="(owner,index) in ownerID" v-show="showRename[owner.id]" :key="'os'+index">
          <input type="text" :placeholder="owner.title" :class="owner.id" />
          <button class="editList" @click="renameCalendar(owner.id)">Cancel</button>
          <button class="editList" @click="uploadRenameO(owner.id)">Confirm</button>
        </li>
        <li v-for="(user,index) in userID" :key="'u'+index" v-show="!showRename[user.id]">
          <input type="color" v-model="user.color" @change="changeColor(user.color,user.id)" />
          <input type="checkbox" :value="user.id" @click="addCalendar" class="sCalendar" />
          <span>{{user.title}}</span>
          <button class="editList" @click="renameCalendar(user.id)">Rename</button>
          <button class="editList" @click="removeCalendar(user.id,user.title)">Delete</button>
        </li>
        <li v-for="(user,index) in userID" :key="'us'+index" v-show="showRename[user.id]">
          <input type="text" :placeholder="user.title" :class="user.id" />
          <button class="editList" @click="renameCalendar(user.id)">Cancel</button>
          <button class="editList" @click="uploadRenameU(user.id)">Confirm</button>
        </li>
        <li v-show="showAddCalendar">
          <input v-model="newCalendar" type="text" />
          <button class="editList" @click="createCalendar">Cancel</button>
          <button class="editList" @click="uploadCalandarCreate">Confirm</button>
        </li>
      </ul>
      <button @click="createCalendar">Add</button>
      <button @click="function(){showCalendarList=!showCalendarList}">Close</button>
    </div>
    <div class="shareCalendar" v-show="showShare">
      <h4>Share the Calendar with:</h4>
      <div v-for="(user,index) in shareUsers" :key="'s'+index">
        <span>User:</span>
        <input type="email" v-model="user.userID" />
        <span>Role:</span>
        <select v-model="user.role">
          <option value="writer">Writer</option>
          <option value="reader">Reader</option>
        </select>
        <button @click="cancelShareUser(index)">-</button>
      </div>
      <div>
        <button @click="addShare">+</button>
      </div>
      <div>
        <button @click="uploadShare">Confirm</button>
        <button @click="cancel">Cancel</button>
      </div>
    </div>
    <div class="deleteCalendar" v-show="showDeleteCalendar">
      <h4>Do you want to remove "{{deleteCalendarTitle}}"?</h4>
      <div>
        <button @click="uploadDeleteCalendar(deleteCalendarID)">Yes</button>
        <button @click="function(){showDeleteCalendar=false}">No</button>
      </div>
    </div>
    <div class="removeCalendar" v-show="showRemoveCalendar">
      <h4>Do you want to remove "{{removeCalendarTitle}}"?</h4>
      <div>
        <button @click="uploadDeleteCalendar(removeCalendarID)">Yes</button>
        <button @click="function(){showRemoveCalendar=false}">No</button>
      </div>
    </div>
    <div class="cannotAdd" v-show="cannotAdd">
      <div class="x">
        <span class="cancel" @click="cancel">X</span>
      </div>
      <h3>Please log in your Google account.</h3>
      <button @click="cancel">Confirm</button>
    </div>
  </div>
</template>
<style scoped>
#calendarPage #calendar .fc-left .fc-button-group button {
  background: #ad9440;
  color: #96031a;
  border: #96031a 1px solid;
}
</style>
<script>
//eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
// import {fullCalendar} from 'vue-fullcalendar'
// import FullCalendar from '../assets/vue-fullcalendar/fullCalendar'
import Vue from "vue";
import moment from "moment";
// import 'fullcalendar/dist/fullcalendar.css'
import "../../static/css/fullcalendar.css";
import { setTimeout } from "timers";
// import { settings } from 'cluster'
export default {
  //   components:{
  //     // 'full-calendar':require('vue-full-calendar')
  //     // 'full-calendar':fullCalendar
  //         FullCalendar,
  //     },
  data() {
    return {
      data: [
        // {
        //   title: "Mumbai Film Week",
        //   start: "2019-09-01",
        //   startTime: "00:01",
        //   endTime: "00:01",
        //   end: "2019-09-05",
        //   color: "#AD9440"
        // },
      ],
      config: {
        // buttonText:{month:"Month",week:"Week",day:"Day"},
        defaultView: "month",
        dayClick: this.dayClick,
        eventClick: this.eventClick,
        selectable: false,
        editable: true,
        eventDrop: this.eventDrop,
        eventResize: this.eventResize
      },
      eventList: [],
      calendarList: [],
      showCalendarList: false,
      isRouterAlive: true,
      token: "",
      isAdd: false,
      dayEvent: [],
      isList: false,
      assignmentData: {},
      legend: [],
      saga: [],
      epic: [],
      story: [],
      newSaga: {},
      newEpic: {},
      newStory: {},
      addData: {},
      editData: {},
      eventSelected: "",
      eventPage: false,
      editOn: false,
      deleteItem: false,
      selectedDay: "",
      ownerID: [],
      userID: [],
      showRename: {},
      showShare: false,
      newCalendar: "",
      showAddCalendar: false,
      showReminder: false,
      showReminderDT: false,
      reminderInfo: [],
      calendarRoles: [],
      showChooseID: false,
      deleteCalendarID: "",
      removeCalendarID: "",
      deleteCalendarTitle: "",
      removeCalendarTitle: "",
      showDeleteCalendar: false,
      showRemoveCalendar: false,
      showAddNotif: false,
      showEditNotif: false,
      isGoogle: false,
      calendarReminderTitle: "",
      cannotAdd: false,
      isNav: false,
      newAssignment: false,
      shareUsers: [
        {
          userID: "",
          role: "writer"
        }
      ]
    };
  },
  methods: {
    cancel() {
      this.isAdd = false;
      this.isList = false;
      this.eventSelected = 0;
      this.editOn = false;
      this.eventPage = false;
      this.deleteItem = false;
      this.editData = {};
      this.addData = {};
      this.showShare = false;
      this.showReminder = false;
      this.showCalendarList = false;
      this.showReminderDT = false;
      this.isGoogle = false;
      this.cannotAdd = false;
      this.isNav = false;
      this.newAssignment = false;
    },
    selectEvent(index) {
      this.eventSelected = index + 1;
      this.eventPage = true;
      this.editOn = false;
      if (this.dayEvent[this.eventSelected - 1]["72dragons"]) {
        this.isGoogle = false;
      } else {
        this.isGoogle = true;
      }
      console.log("this.dayevent", this.dayEvent[this.eventSelected - 1]);
    },
    editEvent() {
      this.editOn = true;
      this.eventPage = false;
      this.editData.calendarID = this.dayEvent[
        this.eventSelected - 1
      ].calendarID;
      this.showNotiEdi();
    },
    closeEdit() {
      this.editOn = false;
      this.eventPage = true;
    },
    deleteOn() {
      this.deleteItem = true;
    },
    closeDelete() {
      this.deleteItem = false;
    },
    eventDrop(
      event,
      dayDelta,
      minuteDelta,
      allDay,
      revertFunc,
      jsEvent,
      ui,
      view
    ) {
      console.log("drop", event, this.data);
      var data = new FormData();
      data.append("title", event.title);
      data.append("desc", event.description);
      data.append("startDate", event.start.format("DD/MM/YY"));
      data.append("endDate", event.end.format("DD/MM/YY"));
      data.append("repeat", 0);
      data.append("storyPoints", event.storyPoint);
      data.append("projectID", event.projectID);
      data.append("storyID", event.storyID);
      data.append("category", event.categoryID);
      data.append("assignmentID", event.assignmentID);
      this.$axios({
        url: `http://192.168.50.90/staff/api/assignments/edit_u`,
        method: "POST",
        data
      }).then(res => {
        console.log(res);
        this.getAssignments();
      });
    },
    eventResize(event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view) {
      console.log("resize", event, this.data);
      var data = new FormData();
      data.append("title", event.title);
      data.append("desc", event.description);
      data.append("startDate", event.start.format("DD/MM/YY"));
      data.append("endDate", event.end.format("DD/MM/YY"));
      data.append("repeat", 0);
      data.append("storyPoints", event.storyPoint);
      data.append("projectID", event.projectID);
      data.append("storyID", event.storyID);
      data.append("category", event.categoryID);
      data.append("assignmentID", event.assignmentID);
      this.$axios({
        url: `http://192.168.50.90/staff/api/assignments/edit_u`,
        method: "POST",
        data
      }).then(res => {
        console.log(res);
        this.getAssignments();
      });
    },
    eventClick(event, jsEvent, pos) {
      console.log("eventClick", event, jsEvent, pos);
      // jsEvent.preventDefault();
    },
    dayClick(day, allDay, jsEvent, view) {
      this.cancel();
      console.log("dayClick", day, allDay, jsEvent, view);
      this.dayEvent = [];
      this.isList = true;
      this.selectedDay = day.format();
      var daystart1 = new Date(
        new Date(day).setDate(new Date(day).getDate() - 1)
      );
      var daystart, daystartM, daystartD;
      if (daystart1.getMonth() < 9) {
        daystartM = "0" + (daystart1.getMonth() + 1);
      } else {
        daystartM = daystart1.getMonth() + 1;
        // daystart = (daystart1.getFullYear()+'-'+(daystart1.getMonth()+1)+'-'+daystart1.getDate()) + "T23:59:00"
      }
      if (daystart1.getDate() < 10) {
        daystartD = "0" + daystart1.getDate();
      } else {
        daystartD = daystart1.getDate();
      }
      daystart =
        daystart1.getFullYear() +
        "-" +
        daystartM +
        "-" +
        daystartD +
        "T23:59:00";
      var dayend = day.format() + "T23:59:00";

      console.log(daystart, dayend);
      console.log(daystart1, daystart1.getDate());
      // console.log(new Date(new Date(day).setDate(new Date(day).getDate()+1)),'????',day.format())
      // console.log('newdate:',new Date(day).getFullYear()+'-'+new Date(day).getMonth()+'-'+(new Date(day).getDate()-1))
      for (let i in this.data) {
        console.log(this.data[i].title);
        console.log("start", this.data[i].start, "<", dayend);
        console.log(
          "ifstart",
          this.data[i].start.split(" ").join("T") <= dayend
        );
        console.log("end", this.data[i].end, ">", daystart);
        console.log("ifend", this.data[i].end.split(" ").join("T") >= daystart);
        if (
          this.data[i].start.split(" ").join("T") <= dayend &&
          this.data[i].end.split(" ").join("T") >= daystart
        ) {
          this.dayEvent.push(this.data[i]);
        }
      }
      console.log("dayevent", this.dayEvent);
      //   var date=new Date(day).getFullYear()+'-'+(new Date(day).getMonth()+1)+'-'+new Date(day).getDate()
      //   console.log(day,new Date(this.data[1].start+'T'+this.data[1].startTime),new Date(new Date(new Date().toLocaleDateString()).setDate(day.getDate()+1)))
      //   for(let i in this.data){
      //     // console.log('datadate',new Date(this.data[i].start),new Date(this.data[i].end),day)
      //     if(new Date(this.data[i].start)<=new Date(new Date(new Date().toLocaleDateString()).setDate(day.getDate()+1)) && new Date(this.data[i].end)>=day){
      //       this.dayEvent.push(this.data[i])
      //       console.log(i)
      //     }
      //   }
      //   console.log('Events of today',this.dayEvent)
    },
    addAssignment() {
      this.cancel();
      this.newAssignment = true;
      var data = new FormData();
      data.append("storyID", 0);
      data.append("type", "self");
      // this.$axios.post(`http://192.168.50.90/staff/api/stories/getchildren`,{
      //   storyID:0,
      //   type:'self'
      // }).then(res=>{
      //   console.log(res)
      // })
      this.$axios({
        url: `http://192.168.50.90/staff/api/stories/getchildren`,
        method: "POST",
        data
        // headers: { "content-type": "multipart/form-data" },
        // transformRequest: [
        //   function(data) {
        //     let ret = "";
        //     for (let it in data) {
        //       ret +=
        //         encodeURIComponent(it) +
        //         "=" +
        //         encodeURIComponent(data[it]) +
        //         "&";
        //     }
        //     return ret;
        //   }
        // ]
      }).then(res => {
        this.legend = [];
        for (let i in res.data) {
          this.legend.push(res.data[i]);
        }
      });
    },
    selectLegend() {
      var data = new FormData();
      if (this.assignmentData.legend) {
        data.append("storyID", this.assignmentData.legend);
        data.append("type", "legend");
        this.$axios({
          url: `http://192.168.50.90/staff/api/stories/getchildren`,
          method: "POST",
          data
          // headers: { "content-type": "application/x-www-form-urlencoded" },
          // transformRequest: [
          //   function(data) {
          //     let ret = "";
          //     for (let it in data) {
          //       ret +=
          //         encodeURIComponent(it) +
          //         "=" +
          //         encodeURIComponent(data[it]) +
          //         "&";
          //     }
          //     return ret;
          //   }
          // ]
        }).then(res => {
          this.saga = [];
          for (let i in res.data) {
            this.saga.push(res.data[i]);
          }
        });
      }
    },
    selectSaga() {
      var data = new FormData();
      if (this.assignmentData.saga == "new") {
        this.assignmentData.epic = "new";
        this.assignmentData.story = "new";
      } else if (this.assignmentData.saga) {
        this.assignmentData.epic = "";
        this.assignmentData.story = "";
        data.append("storyID", this.assignmentData.saga);
        data.append("type", "saga");
        this.$axios({
          url: `http://192.168.50.90/staff/api/stories/getchildren`,
          method: "POST",
          data
          // headers: { "content-type": "application/x-www-form-urlencoded" },
          // transformRequest: [
          //   function(data) {
          //     let ret = "";
          //     for (let it in data) {
          //       ret +=
          //         encodeURIComponent(it) +
          //         "=" +
          //         encodeURIComponent(data[it]) +
          //         "&";
          //     }
          //     return ret;
          //   }
          // ]
        }).then(res => {
          this.epic = [];
          for (let i in res.data) {
            this.epic.push(res.data[i]);
          }
        });
      }
      this.newAssignment = false;
      this.newAssignment = true;
    },
    selectEpic() {
      var data = new FormData();
      if (this.assignmentData.epic == "new") {
        this.assignmentData.story = "new";
      } else {
        data.append("storyID", this.assignmentData.epic);
        data.append("type", "epic");
        this.$axios({
          url: `http://192.168.50.90/staff/api/stories/getchildren`,
          method: "POST",
          data
          // headers: { "content-type": "application/x-www-form-urlencoded" },
          // transformRequest: [
          //   function(data) {
          //     let ret = "";
          //     for (let it in data) {
          //       ret +=
          //         encodeURIComponent(it) +
          //         "=" +
          //         encodeURIComponent(data[it]) +
          //         "&";
          //     }
          //     return ret;
          //   }
          // ]
        }).then(res => {
          this.story = [];
          for (let i in res.data) {
            this.story.push(res.data[i]);
          }
        });
      }
      this.newAssignment = false;
      this.newAssignment = true;
    },
    selectStory() {
      this.newAssignment = false;
      this.newAssignment = true;
    },
    uploadAssignment() {
      var data = new FormData(),
        startDate =
          this.assignmentData.start.substring(8) +
          "/" +
          this.assignmentData.start.substring(5, 7) +
          "/" +
          this.assignmentData.start.substring(2, 4),
        endDate =
          this.assignmentData.end.substring(8) +
          "/" +
          this.assignmentData.end.substring(5, 7) +
          "/" +
          this.assignmentData.end.substring(2, 4);
      if (this.assignmentData.saga == "new") {
        data.append("projectData[title]", this.newSaga.title);
        data.append("projectData[desc]", this.newSaga.description);
        data.append("projectData[parentID]", this.assignmentData.legend);
        this.$axios({
          url: `http://192.168.50.90/staff/api/projects/create`,
          method: "POST",
          data
        }).then(res => {
          console.log("Saga", res);
          data = new FormData();
          data.append("title", this.newEpic.title);
          data.append("description", this.newEpic.description);
          data.append("type", "Epic");
          data.append("parentID", res.data.projectID.storyID);
          data.append("departmentID", null);
          this.$axios({
            url: `http://192.168.50.90/staff/api/stories/create`,
            method: "POST",
            data
          }).then(resp => {
            console.log("Epic", resp);
            data = new FormData();
            data.append("title", this.newStory.title);
            data.append("description", this.newStory.description);
            data.append("type", "Story");
            data.append("parentID", resp.data.storyID);
            data.append("departmentID", null);
            this.$axios({
              url: `http://192.168.50.90/staff/api/stories/create`,
              method: "POST",
              data
            }).then(response => {
              console.log("Story", response);
              data = new FormData();
              data.append("title", this.assignmentData.title);
              data.append("desc", this.assignmentData.description);
              data.append("startDate", startDate);
              data.append("endDate", endDate);
              data.append("repeat", 0);
              data.append("storyPoints", this.assignmentData.sPoint);
              data.append("projectID", res.data.projectID.storyID);
              data.append("storyID", response.data.storyID);
              data.append("category", 0);
              this.$axios({
                url: `http://192.168.50.90/staff/api/assignments/create`,
                method: "POST",
                data
              }).then(data => {
                console.log(data);
                this.getAssignments();
                this.assignmentData = {};
                this.legend = [];
                this.saga = [];
                this.epic = [];
                this.story = [];
                setTimeout(() => {
                  this.cancel();
                }, 10);
              });
            });
          });
        });
      } else if (this.assignmentData.epic == "new") {
        data = new FormData();
        data.append("title", this.newEpic.title);
        data.append("description", this.newEpic.description);
        data.append("type", "Epic");
        data.append("parentID", this.assignmentData.saga);
        data.append("departmentID", null);
        this.$axios({
          url: `http://192.168.50.90/staff/api/stories/create`,
          method: "POST",
          data
        }).then(resp => {
          console.log("Epic", resp);
          data = new FormData();
          data.append("title", this.newStory.title);
          data.append("description", this.newStory.description);
          data.append("type", "Story");
          data.append("parentID", resp.data.storyID);
          data.append("departmentID", null);
          this.$axios({
            url: `http://192.168.50.90/staff/api/stories/create`,
            method: "POST",
            data
          }).then(response => {
            console.log("Story", response);
            data = new FormData();
            data.append("title", this.assignmentData.title);
            data.append("desc", this.assignmentData.description);
            data.append("startDate", startDate);
            data.append("endDate", endDate);
            data.append("repeat", 0);
            data.append("storyPoints", this.assignmentData.sPoint);
            data.append("projectID", this.assignmentData.saga);
            data.append("storyID", response.data.storyID);
            data.append("category", 0);
            this.$axios({
              url: `http://192.168.50.90/staff/api/assignments/create`,
              method: "POST",
              data
            }).then(data => {
              console.log(data);
              this.getAssignments();
              this.assignmentData = {};
              this.legend = [];
              this.saga = [];
              this.epic = [];
              this.story = [];
              setTimeout(() => {
                this.cancel();
              }, 10);
            });
          });
        });
      } else if (this.assignmentData.story == "new") {
        console.log("nst");
        data = new FormData();
        data.append("title", this.newStory.title);
        data.append("description", this.newStory.description);
        data.append("type", "Story");
        data.append("parentID", this.assignmentData.epic);
        data.append("departmentID", null);
        this.$axios({
          url: `http://192.168.50.90/staff/api/stories/create`,
          method: "POST",
          data
        }).then(response => {
          console.log("Story", response);
          data = new FormData();
          data.append("title", this.assignmentData.title);
          data.append("desc", this.assignmentData.description);
          data.append("startDate", startDate);
          data.append("endDate", endDate);
          data.append("repeat", 0);
          data.append("storyPoints", this.assignmentData.sPoint);
          data.append("projectID", this.assignmentData.saga);
          data.append("storyID", response.data.storyID);
          data.append("category", 0);
          this.$axios({
            url: `http://192.168.50.90/staff/api/assignments/create`,
            method: "POST",
            data
          }).then(data => {
            console.log(data);
            this.getAssignments();
            this.assignmentData = {};
            this.legend = [];
            this.saga = [];
            this.epic = [];
            this.story = [];
            setTimeout(() => {
              this.cancel();
            }, 10);
          });
        });
      } else {
        data = new FormData();
        data.append("title", this.assignmentData.title);
        data.append("desc", this.assignmentData.description);
        data.append("startDate", startDate);
        data.append("endDate", endDate);
        data.append("repeat", 0);
        data.append("storyPoints", this.assignmentData.sPoint);
        data.append("projectID", this.assignmentData.saga);
        data.append("storyID", this.assignmentData.story);
        data.append("category", 0);
        console.log(data);
        this.$axios({
          url: `http://192.168.50.90/staff/api/assignments/create`,
          method: "POST",
          data
        }).then(res => {
          console.log(res);
          this.getAssignments();
          this.assignmentData = {};
          this.legend = [];
          this.saga = [];
          this.epic = [];
          this.story = [];
          setTimeout(() => {
            this.cancel();
          }, 10);
        });
      }
    },
    // moreClick (day, events, jsEvent) {
    //   // console.log('moreCLick', day, events, jsEvent)
    //   this.$children[0].$children[1].showMore=false
    //   console.log(day)
    //   this.dayClick(day,jsEvent)
    // },
    addEvent() {
      this.cancel();
      this.addData = {};
      if (this.token) {
        this.isAdd = true;
      } else {
        this.cannotAdd = true;
      }

      console.log(document.getElementsByClassName("startT")[0].value);
    },
    // getRoles(calendarID) {
    //   this.$axios
    //     .get(
    //       `https://www.googleapis.com/calendar/v3/calendars/${calendarID}/acl?access_token=${this.token}`
    //     )
    //     .then(res => {
    //       console.log(res);
    //       this.calendarRoles = res.data.items;
    //       console.log(this.calendarRoles, res.data.items);
    //     });
    // },
    showNotiAdd() {
      this.ownerID.filter(owner => owner.id == this.addData.calendarID).length
        ? (this.showAddNotif = true)
        : (this.showAddNotif = false);
    },
    showNotiEdi() {
      this.ownerID.filter(owner => owner.id == this.editData.calendarID).length
        ? (this.showEditNotif = true)
        : (this.showEditNotif = false);
    },
    uploadEvent() {
      var data = {};
      var attendees = [];
      // this.getRoles(calendarID);
      if (
        this.ownerID.filter(owner => owner.id == this.addData.calendarID).length
      ) {
        this.$axios
          .get(
            `https://www.googleapis.com/calendar/v3/calendars/${this.addData.calendarID}/acl?access_token=${this.token}`
          )
          .then(res => {
            console.log("roles", res);
            this.calendarRoles = res.data.items;
            for (let i in this.calendarRoles) {
              let index = this.calendarRoles[i].id.indexOf(":");
              if (this.calendarRoles[i].id.indexOf("@") != -1) {
                attendees.push({
                  comment: "Join this event, plz",
                  email: this.calendarRoles[i].id.substring(index + 1),
                  optional: true
                });
              }
            }
            data = {
              summary: this.addData.title,
              start: {
                dateTime:
                  this.addData.start + "T" + this.addData.startTime + ":00",
                timeZone: this.addData.timeZone
              },
              end: {
                dateTime: this.addData.end + "T" + this.addData.endTime + ":00",
                timeZone: this.addData.timeZone
              },
              description: this.addData.description,
              attendees,
              sendUpdates: ""
            };
            if (
              document.getElementsByClassName("checkNotiA")[0].checked == true
            ) {
              data.sendUpdates = "all";
            } else {
              data.sendUpdates = "none";
            }
            // console.log('add',this.addData,data)
            this.$axios
              .post(
                `https://www.googleapis.com/calendar/v3/calendars/${this.addData.calendarID}/events?alt=json&access_token=${this.token}&sendUpdates=${data.sendUpdates}`,
                data
              )
              .then(res => {
                console.log(res);
                this.data = [];
                this.getCalendar();
                this.isAdd = false;
                this.isList = false;
                this.eventSelected = 0;
                this.editOn = false;
                this.eventPage = false;
                this.deleteItem = false;
                this.editData = {};
                this.addData = {};
                this.showAddNotif = false;
              });
          });
      } else {
        data = {
          summary: this.addData.title,
          start: {
            dateTime: this.addData.start + "T" + this.addData.startTime + ":00",
            timeZone: this.addData.timeZone
          },
          end: {
            dateTime: this.addData.end + "T" + this.addData.endTime + ":00",
            timeZone: this.addData.timeZone
          },
          description: this.addData.description
        };
        this.$axios
          .post(
            `https://www.googleapis.com/calendar/v3/calendars/${this.addData.calendarID}/events?alt=json&access_token=${this.token}`,
            data
          )
          .then(res => {
            console.log(res);
            this.data = [];
            this.getCalendar();
            // this.isAdd = false;
            // this.isList = false;
            // this.eventSelected = 0;
            // this.editOn = false;
            // this.eventPage = false;
            // this.deleteItem = false;
            this.cancel();
            this.editData = {};
            this.addData = {};
            this.showAddNotif = false;
          });
      }
    },
    uploadEdit(index) {
      if (this.dayEvent[eventSelected - 1]["72dragons"]) {
        console.log("Yes");
      }
      var data = {};
      // this.getRoles(this.dayEvent[index].calendarID)
      // if (
      //   this.ownerID.filter(owner => owner.id == this.editData.calendarID)
      //     .length
      // ) {
      //   this.$axios
      //     .get(
      //       `https://www.googleapis.com/calendar/v3/calendars/${this.dayEvent[index].calendarID}/acl?access_token=${this.token}`
      //     )
      //     .then(res => {
      //       console.log(res);
      //       this.calendarRoles = res.data.items;
      //       for (let i in this.calendarRoles) {
      //         let index = this.calendarRoles[i].id.indexOf(":");
      //         if (this.calendarRoles[i].id.indexOf("@") != -1) {
      //           attendees.push({
      //             comment: "Join this event, plz",
      //             email: this.calendarRoles[i].id.substring(index + 1),
      //             optional: true
      //           });
      //         }
      //       }
      //       data = {
      //         summary: this.editData.title,
      //         start: {
      //           dateTime:
      //             this.editData.start + "T" + this.editData.startTime + ":00",
      //           timeZone: this.editData.timeZone
      //         },
      //         end: {
      //           dateTime:
      //             this.editData.end + "T" + this.editData.endTime + ":00",
      //           timeZone: this.editData.timeZone
      //         },
      //         description: this.editData.description,
      //         attendees,
      //         sendUpdates: ""
      //       };
      //       if (
      //         document.getElementsByClassName("checkNotiE")[0].checked == true
      //       ) {
      //         data.sendUpdates = "all";
      //       } else {
      //         data.sendUpdates = "none";
      //       }
      //       this.$axios
      //         .put(
      //           `https://www.googleapis.com/calendar/v3/calendars/${this.dayEvent[index].calendarID}/events/${this.dayEvent[index].id}?alt=json&access_token=${this.token}&sendUpdates=${data.sendUpdates}`,
      //           data
      //         )
      //         .then(res => {
      //           console.log(res);
      //           this.data = [];
      //           this.getCalendar();
      //           // this.isAdd = false;
      //           // this.isList = false;
      //           // this.eventSelected = 0;
      //           // this.editOn = false;
      //           // this.eventPage = false;
      //           // this.deleteItem = false;
      //           this.cancel();
      //           this.editData = {};
      //           this.addData = {};
      //         });
      //     });
      // } else {
      //   data = {
      //     summary: this.editData.title,
      //     start: {
      //       dateTime:
      //         this.editData.start + "T" + this.editData.startTime + ":00",
      //       timeZone: this.editData.timeZone
      //     },
      //     end: {
      //       dateTime: this.editData.end + "T" + this.editData.endTime + ":00",
      //       timeZone: this.editData.timeZone
      //     },
      //     description: this.editData.description
      //   };
      // }
      data = {
        summary: this.editData.title,
        start: {
          dateTime: this.editData.start + "T" + this.editData.startTime + ":00",
          timeZone: this.editData.timeZone
        },
        end: {
          dateTime: this.editData.end + "T" + this.editData.endTime + ":00",
          timeZone: this.editData.timeZone
        },
        description: this.editData.description,
        attendees: this.dayEvent[index].attendees,
        sendUpdates: ""
      };
      if (document.getElementsByClassName("checkNotiE")[0].checked == true) {
        data.sendUpdates = "all";
      } else {
        data.sendUpdates = "none";
      }
      this.$axios
        .put(
          `https://www.googleapis.com/calendar/v3/calendars/${this.dayEvent[index].calendarID}/events/${this.dayEvent[index].id}?alt=json&access_token=${this.token}&sendUpdates=${data.sendUpdates}`,
          data
        )
        .then(res => {
          console.log(res);
          this.data = [];
          this.getCalendar();
          this.cancel();
          this.editData = {};
          this.addData = {};
        });
    },
    deleteEvent(index) {
      var thisVue = this;
      console.log(this.dayEvent);
      this.$axios
        .delete(
          `https://www.googleapis.com/calendar/v3/calendars/${thisVue.dayEvent[index].calendarID}/events/${thisVue.dayEvent[index].id}?alt=json&access_token=${this.token}`
        )
        .then(res => {
          console.log(res);
          this.getCalendar();
          this.cancel();
          this.editData = {};
          this.addData = {};
        });
    },
    addDelete() {
      this.cancel();
      if (this.token) {
        this.showCalendarList = !this.showCalendarList;
        var sCalendar = document.getElementsByClassName("sCalendar");
        for (let i in this.calendarList) {
          for (let j in sCalendar) {
            if (this.calendarList[i].calendarID == sCalendar[j].value) {
              sCalendar[j].checked = true;
            }
          }
        }
      } else {
        this.cannotAdd = true;
      }
    },
    addCalendar(event) {
      if (event.target.checked == true) {
        this.getList(event.target.value);
      } else {
        for (let i = this.data.length - 1; i >= 0; i--) {
          if (this.data[i].calendarID == event.target.value) {
            this.data.splice(i, 1);
          }
        }
        for (let i in this.calendarList) {
          if (this.calendarList[i].calendarID == event.target.value) {
            this.calendarList.splice(i, 1);
          }
        }
        // this.$axios
        //   .delete(`http://www.googleapis.com/calendar/v3/users/me/calendarList/${event.target.value}?access_token=${this.token}`)
        //   .then(res=>{
        //     console.log(res)
        //   })
      }
    },
    uploadShare() {
      var data = [];
      for (let i in this.shareUsers) {
        data.push({
          role: this.shareUsers[i].role,
          scope: {
            type: "user",
            value: this.shareUsers[i].userID
          }
        });
      }
      for (let i in data) {
        this.$axios
          .post(
            `https://www.googleapis.com/calendar/v3/calendars/${this.calendarShareID}/acl?access_token=${this.token}`,
            data[i]
          )
          .then(res => {
            console.log(res);
            this.cancel();
          });
      }
    },
    createCalendar() {
      this.showAddCalendar = !this.showAddCalendar;
    },
    uploadCalandarCreate() {
      this.$axios
        .post(
          `https://www.googleapis.com/calendar/v3/calendars?access_token=${this.token}`,
          {
            summary: this.newCalendar
          }
        )
        .then(res => {
          console.log(res);
          this.getCalendar();
        });
    },
    reminder() {
      this.cancel();
      if (this.token) {
        this.showReminder = !this.showReminder;
      } else {
        this.cannotAdd = true;
      }
    },
    getReminder(id) {
      console.log(id);
      for (let i in this.ownerID) {
        if (id == this.ownerID[i].id) {
          this.reminderInfo = this.ownerID[i].reminder;
          this.calendarReminderTitle = this.ownerID[i].title;
        }
      }
      for (let j in this.userID) {
        if (id == this.userID[j].id) {
          this.reminderInfo = this.userID[j].reminder;
          this.calendarReminderTitle = this.userID[j].title;
        }
      }
      if (this.reminderInfo.length == 0) {
        this.reminderInfo = [
          {
            method: "email",
            minutes: 0
          }
        ];
      }
      this.showReminderDT = true;
      this.calendarReminderID = id;
      // reminders: {
      //     useDefault: false,
      //     overrides: [
      //       {
      //         method: "email",
      //         minutes: 2
      //       }
      //     ]
      //   },
    },
    uploadreminders(calendarID) {
      this.$axios
        .put(
          `https://www.googleapis.com/calendar/v3/users/me/calendarList/${calendarID}?access_token=${this.token}`,
          {
            defaultReminders: this.reminderInfo
          }
        )
        .then(res => {
          console.log(res);
          this.showReminder = false;
        });
    },
    addNewReminder() {
      this.reminderInfo.push({
        method: "email",
        minutes: 0
      });
    },
    cancelNewReminder(index) {
      this.reminderInfo.splice(index, 1);
    },
    getCode() {
      console.log("getting code ...");
      window.location.href =
        "https://accounts.google.com/o/oauth2/v2/auth?scope=https:%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar+https:%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar.events+https:%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar.settings.readonly&response_type=code&redirect_uri=http:%2F%2Flocalhost:8080&client_id=27675862201-qgk4tq3otjqjkuhalk67bcvbroecvptn.apps.googleusercontent.com&code_challenge=musicplay&code_challenge_method=plain&state=security_token%253D138r5719ru3e1%2526url%253Dhttps:%2F%2Foauth2.example.com%2Ftoken&access_type=offline&prompt=consent";
      // this.$axios
      //   .get("https://accounts.google.com/o/oauth2/v2/auth", {
      //     params: {
      //       scope:
      //         "https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/calendar.events https://www.googleapis.com/auth/calendar.settings.readonly",
      //       response_type: "code",
      //       redirect_uri: "http://localhost:8080",
      //       client_id:
      //         "27675862201-qgk4tq3otjqjkuhalk67bcvbroecvptn.apps.googleusercontent.com",
      //       code_challenge: "musicplay",
      //       code_challenge_method: "plain",
      //       state:
      //         "security_token%3D138r5719ru3e1%26url%3Dhttps://oauth2.example.com/token",
      //       access_type: "offline",
      //       prompt: "consent"
      //     }
      //   })
      //   .then(res => {
      //     console.log('result',res);
      //   })
      //   .catch(error =>{
      //     console.log('error',error)
      // });
    },
    getToken() {
      var thisVue = this;
      console.log("getting token ...");
      this.$axios
        .post("https://accounts.google.com/o/oauth2/token", {
          code: thisVue.code,
          redirect_uri: "http://localhost:8080",
          grant_type: "authorization_code",
          client_id:
            "27675862201-qgk4tq3otjqjkuhalk67bcvbroecvptn.apps.googleusercontent.com",
          client_secret: "JN66id-oKDPHf04BJe4Z8g9f",
          code_verifier: "musicplay",
          scope:
            "https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/calendar.events https://www.googleapis.com/auth/calendar.settings.readonly"
        })
        .then(res => {
          console.log("token:", res);
          this.token = res.data.access_token;
          this.getCalendar();
        });
    },
    getCalendar() {
      this.ownerID = [];
      this.userID = [];
      this.calendarList = [];
      this.data = [];
      this.$axios
        .get(
          `https://www.googleapis.com/calendar/v3/users/me/calendarList?access_token=${this.token}`
        )
        .then(res => {
          console.log("calendarID", res);
          for (let i in res.data.items) {
            if (res.data.items[i].accessRole == "owner") {
              this.ownerID.push({
                id: res.data.items[i].id,
                title: res.data.items[i].summary,
                color: res.data.items[i].backgroundColor,
                reminder: res.data.items[i].defaultReminders
              });
            } else {
              this.userID.push({
                id: res.data.items[i].id,
                color: res.data.items[i].backgroundColor,
                title: res.data.items[i].summaryOverride
                  ? res.data.items[i].summaryOverride
                  : res.data.items[i].summary,
                reminder: res.data.items[i].defaultReminders
              });
            }
            Vue.set(this.showRename, res.data.items[i].id, false);
          }
          console.log("ownerID", this.ownerID, "userID", this.userID);
          this.getList(this.ownerID[0].id);
        });
    },
    getList(calendarID) {
      var thisVue = this;
      console.log("Getting List...");
      thisVue.$axios
        .get(
          `https://www.googleapis.com/calendar/v3/calendars/${calendarID}/events`,
          {
            params: {
              access_token: this.token
            }
          }
        )
        .then(res => {
          console.log("eventList:", res);
          thisVue.calendarList.push({
            calendarID,
            data: res.data.items
          });
          console.log("calendarList:", thisVue.calendarList);
          this.loadCalendar(calendarID);
          // this.reload()
        });
    },
    loadCalendar(calendarID) {
      var thisVue = this;
      var item = {};
      // thisVue.data = [];
      for (let index in thisVue.calendarList) {
        if (thisVue.calendarList[index].calendarID == calendarID) {
          thisVue.eventList = thisVue.calendarList[index].data;
        }
      }
      for (let i in thisVue.eventList) {
        item = {};
        if (thisVue.eventList[i].summary) {
          // thisVue.data[i]['title']=thisVue.eventList[i].summary
          Vue.set(item, "title", thisVue.eventList[i].summary);
        } else {
          // thisVue.data[i]['title']='No title'
          Vue.set(item, "title", "No Title");
        }
        if (thisVue.eventList[i].start.date) {
          // thisVue.data[i]['start']=thisVue.eventList[i].start.date
          Vue.set(item, "start", thisVue.eventList[i].start.date);
          // thisVue.data[i]['end']=thisVue.eventList[i].end.date
          Vue.set(item, "end", thisVue.eventList[i].end.date);
          // }else if(!!thisVue.eventList[i].start.dateTime){
        } else {
          var str = thisVue.eventList[i].start.dateTime;
          var ed = thisVue.eventList[i].end.dateTime;
          // thisVue.data[i]['start']=str.substr(0,10)
          Vue.set(item, "start", str.substr(0, 10) + " " + str.substr(11, 8));
          // thisVue.data[i]['end']=ed.substr(0,10)
          Vue.set(item, "end", ed.substr(0, 10) + " " + ed.substr(11, 8));
          // thisVue.data[i]['startTime']=str.substr(11,8)
          // Vue.set(thisVue.data[i],'startTime',)
          // thisVue.data[i]['endTime']=ed.substr(11,8)
          // Vue.set(thisVue.data[i],'endTime',)
        }
        if (thisVue.eventList[i].description) {
          Vue.set(item, "description", thisVue.eventList[i].description);
        } else {
          Vue.set(item, "description", "No information");
        }
        // thisVue.data[i]['cssClass']='gold'
        for (let j in thisVue.ownerID) {
          if (calendarID == thisVue.ownerID[j].id) {
            Vue.set(item, "color", thisVue.ownerID[j].color);
          }
        }
        for (let i in thisVue.userID) {
          if (calendarID == thisVue.userID[i].id) {
            Vue.set(item, "color", thisVue.userID[i].color);
          }
        }

        // thisVue.data[i]['id']=thisVue.eventList[i].id
        Vue.set(item, "id", thisVue.eventList[i].id);
        Vue.set(item, "calendarID", calendarID);
        if (thisVue.eventList[i].attendees) {
          Vue.set(item, "attendees", thisVue.eventList[i].attendees);
        } else {
          Vue.set(item, "attendees", "Unknown");
        }
        thisVue.data.push(item);
      }
      console.log(this.data);
    },
    renameCalendar(calendarID) {
      console.log(this.showRename);
      this.showRename[calendarID] = !this.showRename[calendarID];
    },
    uploadRenameO(calendarID) {
      this.$axios
        .put(
          `https://www.googleapis.com/calendar/v3/calendars/${calendarID}?access_token=${this.token}`,
          {
            summary: document.getElementsByClassName(calendarID)[0].value
          }
        )
        .then(res => {
          console.log(res);
          this.getCalendar();
        });
    },
    uploadRenameU(calendarID) {
      this.$axios
        .put(
          `https://www.googleapis.com/calendar/v3/users/me/calendarList/${calendarID}?access_token=${this.token}`,
          {
            summaryOverride: document.getElementsByClassName(calendarID)[0]
              .value
          }
        )
        .then(res => {
          console.log(res);
          this.getCalendar();
        });
    },
    shareCalendar(calendarID) {
      this.cancel();
      this.showShare = !this.showShare;
      this.calendarShareID = calendarID;
    },
    addShare() {
      this.shareUsers.push({
        userID: "",
        role: "writer"
      });
      console.log(this.shareUsers);
    },
    cancelShareUser(index) {
      this.shareUsers.splice(index, 1);
      console.log(this.shareUsers);
    },
    deleteCalendar(calendarID, calendarTitle) {
      this.showDeleteCalendar = true;
      this.deleteCalendarID = calendarID;
      this.deleteCalendarTitle = calendarTitle;
    },
    removeCalendar(calendarID, calendarTitle) {
      this.showRemoveCalendar = true;
      this.removeCalendarID = calendarID;
      this.removeCalendarTitle = calendarTitle;
    },
    uploadDeleteCalendar(calendarID) {
      this.showDeleteCalendar = false;
      this.$axios
        .delete(
          `https://www.googleapis.com/calendar/v3/calendars/${calendarID}?access_token=${this.token}`
        )
        .then(res => {
          console.log(res);
          this.getCalendar();
        });
    },
    uploadRemoveCalendar(calendarID) {
      this.showRemoveCalendar = false;
      this.$axios
        .delete(
          `https://www.googleapis.com/calendar/v3/users/me/calendarList/${calendarID}?access_token=${this.token}`
        )
        .then(res => {
          console.log(res);
          this.getCalendar();
        });
    },
    // reload() {
    //   this.isRouterAlive = false;
    //   this.$nextTick(function() {
    //     this.isRouterAlive = true;
    //   });
    // },
    getParams() {
      var url = location.href;
      var params = url.substring(url.indexOf("?") + 1).split("&");
      this.code = params[1].split("=")[1];
      console.log(this.code);
      this.getToken();
    },
    download() {
      var rows = [
        [
          "Calendar",
          "Title",
          "Start",
          "End",
          "Description",
          "Attendees",
          "Location"
        ]
      ];
      var data = this.data;
      for (let i in data) {
        if (data[i].attendees == "Unknown") {
          rows.push([
            data[i].calendarID,
            data[i].title,
            data[i].start,
            data[i].end,
            `"${data[i].description}"`,
            "Unknown",
            " "
          ]);
        } else {
          var attendees = [];
          for (let j in data[i].attendees) {
            attendees.push(data[i].attendees[j].email);
          }
          rows.push([
            data[i].calendarID,
            data[i].title,
            data[i].start,
            data[i].end,
            `"${data[i].description}"`,
            `"${attendees.join(",\n")}"`,
            " "
          ]);
        }
      }
      var csvRows = [];
      for (let k in rows) {
        csvRows.push(rows[k].join(","));
      }
      var csvData = csvRows.join("\n");
      var BOM = "\uFEFF";
      csvData = BOM + csvData;
      var a = document.createElement("a");
      a.download = "CalendarEvents.csv";
      a.style.display = "none";
      a.href = "data:attachment/csv," + encodeURI(csvData);
      a.target = "_blank";
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    },
    changeColor(color, calendarID) {
      console.log(color, calendarID);
      this.$axios
        .put(
          `https://www.googleapis.com/calendar/v3/users/me/calendarList/${calendarID}?access_token=${this.token}&colorRgbFormat=true`,
          {
            backgroundColor: color,
            foregroundColor: "#000000"
          }
        )
        .then(res => {
          console.log(res);
          this.getCalendar();
          this.showCalendarList = false;
        })
        .catch(err => {
          console.log(err);
        });
    },
    getAssignments() {
      console.log(
        this.$refs.calendar.fireMethod("getView").start.format("YYYY/MM/DD"),
        this.$refs.calendar.fireMethod("getView").end.format("YYYY/MM/DD")
      );
      for (let event in this.data) {
        if (this.data[event]["72dragons"]) {
          this.data.splice(event);
        }
      }
      var fd = new FormData();
      fd.append(
        "startDate",
        this.$refs.calendar.fireMethod("getView").start.format("YYYY/MM/DD")
      );
      fd.append(
        "endDate",
        this.$refs.calendar.fireMethod("getView").end.format("YYYY/MM/DD")
      );
      this.$axios({
        method: "POST",
        url: `http://192.168.50.90/staff/api/assignments/list`,
        crossdomain: true,
        data: fd,
        // data: {
        //   startDate: this.$refs.calendar
        //     .fireMethod("getView")
        //     .start.format("YYYY/MM/DD"),
        //   endDate: this.$refs.calendar
        //     .fireMethod("getView")
        //     .end.format("YYYY/MM/DD")
        // },
        headers: { "Content-Type": "multipart/form-data" }
      }).then(res => {
        console.log(res);
        var item = {};
        this.eventList = res.data;
        console.log("assig", this.eventList);
        for (let i in this.eventList) {
          item = {};
          Vue.set(item, "title", this.eventList[i].title);
          Vue.set(item, "start", this.eventList[i].startingDate);
          Vue.set(item, "end", this.eventList[i].endDate);
          Vue.set(item, "color", "#AD9440");
          Vue.set(item, "72dragons", true);
          Vue.set(item, "assignmentID", this.eventList[i].assignmentID);
          Vue.set(item, "description", this.eventList[i].description);
          Vue.set(item, "storyPoint", this.eventList[i].estStoryPoints);
          Vue.set(item, "projectID", this.eventList[i].epicID);
          Vue.set(item, "storyID", this.eventList[i].storyID);
          Vue.set(item, "categoryID", this.eventList[i].categoryID);
          this.data.push(item);
        }
        console.log("data：", this.data);
      });
    },
    resizeCalendar() {
      var nav,
        header =
          parseInt(
            getComputedStyle(
              document.getElementsByClassName("fc-header-toolbar")[0]
            ).height
          ) +
          parseInt(
            getComputedStyle(
              document.getElementsByClassName("fc-header-toolbar")[0]
            ).margin
          ) *
            2,
        calendar = document.getElementsByClassName("fc-view-container")[0];
      if (window.innerWidth >= 768) {
        nav = 100;
      } else {
        nav = 52;
      }
      console.log(header);
      calendar.style.height = window.innerHeight - nav - header + "px";
    }
  },
  mounted() {
    console.log("mounted");
    this.$nextTick(() => {
      var thisV = this;
      thisV.resizeCalendar();
      thisV.getAssignments();
      var btnPrev = document.getElementsByClassName("fc-prev-button")[0],
        btnNext = document.getElementsByClassName("fc-next-button")[0],
        btnMonth = document.getElementsByClassName("fc-month-button")[0],
        btnWeek = document.getElementsByClassName("fc-agendaWeek-button")[0],
        btnDay = document.getElementsByClassName("fc-agendaDay-button")[0];
      console.log(btnPrev, btnNext, btnMonth, btnWeek, btnDay);
      btnPrev.onclick = function() {
        thisV.cancel();
        setTimeout(function() {
          thisV.resizeCalendar();
        }, 100);
        thisV.getAssignments();
      };
      btnNext.onclick = function() {
        thisV.cancel();
        setTimeout(function() {
          thisV.resizeCalendar();
        }, 100);

        thisV.getAssignments();
      };
      btnMonth.onclick = function() {
        thisV.cancel();
        setTimeout(function() {
          thisV.resizeCalendar();
        }, 100);
        thisV.getAssignments();
      };
      btnWeek.onclick = function() {
        thisV.cancel();
        setTimeout(function() {
          thisV.resizeCalendar();
        }, 100);
        thisV.getAssignments();
      };
      btnDay.onclick = function() {
        thisV.cancel();
        setTimeout(function() {
          thisV.resizeCalendar();
        }, 100);
        thisV.getAssignments();
      };
      window.onresize = function() {
        thisV.resizeCalendar();
      };
    });
    this.getParams();
  }
};
</script>
<style scoped>
@import "../../static/css/calendarTwo";
/* @import "../../static/css/all"; */
</style>

