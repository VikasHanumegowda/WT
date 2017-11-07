import {Injectable} from '@angular/core';
import {Http} from '@angular/http';

import {Observable} from 'rxjs/Observable';
import 'rxjs/add/operator/map';


@Injectable()
export class APIService {

  constructor(private http: Http) {
  }

  search(term: string): Promise {
    return this.http
      .get(``)
      .map(response => response.json().data as Hero[]);
  }
}
