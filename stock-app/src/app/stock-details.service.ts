import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';

@Injectable()
export class StockDetailsService {
  private myData: any;

  constructor(private http: HttpClient) {
  }

  getStockInfo(): object {
    $http.get('http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input=Apple').then(function(response) {
      this.myData = response.data.records;
    });
    return this.myData;
  }
}
