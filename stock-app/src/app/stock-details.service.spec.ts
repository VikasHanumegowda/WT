import { TestBed, inject } from '@angular/core/testing';

import { StockDetailsService } from './stock-details.service';

describe('StockDetailsService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [StockDetailsService]
    });
  });

  it('should be created', inject([StockDetailsService], (service: StockDetailsService) => {
    expect(service).toBeTruthy();
  }));
});
