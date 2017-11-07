import {Component} from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {

  public makeCalls() {
    const xmlHttp = new XMLHttpRequest();
    console.log('XMLHTTP');
    xmlHttp.open('GET', 'http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input=Apple', false); // false for synchronous request
    xmlHttp.onreadystatechange = function () {
      if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
        console.log('XMLHTTP');
        alert(xmlHttp.responseText);
      }
    };
  }
}
