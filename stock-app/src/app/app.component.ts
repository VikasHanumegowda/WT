import {Component} from '@angular/core';
import {StockDetailsService} from './stock-details.service';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'appp';
  constructor(private stockDetailsService: StockDetailsService){}

  public myFunc() {

  }
}
