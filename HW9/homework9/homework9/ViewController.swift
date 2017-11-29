//
//  ViewController.swift
//  homework9
//
//  Created by Vikas Hanumegowda on 11/22/17.
//  Copyright © 2017 Vikas Hanumegowda. All rights reserved.
//

import UIKit

class ViewController: UIViewController, UIPickerViewDelegate, UIPickerViewDataSource {
    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        return 1
    }
    
    
    var pickerOptions : [String]!
    
    var picker1Options : [String]!
    
    @IBOutlet weak var outputlabel: UILabel!
    @IBOutlet weak var symbolIP: UITextField!
    
    
    @IBOutlet weak var picker: UIPickerView!
    @IBOutlet weak var pickerV: UIPickerView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        pickerOptions = ["Default","Symbol","Stock Price","Change","Change%"]
        picker1Options = ["Ascending","Descending"]
    }

    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        if (pickerView.tag == 1){
            return picker1Options.count
        }else{
            return pickerOptions.count
        }
        
    }

    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String?{
        if(pickerView.tag == 1){
            return picker1Options[row]
            
        }
        else{
            return pickerOptions[row]
        }
    }
    
    func pickerView(_ pickerView: UIPickerView, rowHeightForComponent component: Int) -> CGFloat{
        return 90.0;
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    @IBAction func submitAction(_ sender: UIButton) {
        let inputSymbol = symbolIP.text
        outputlabel.text = inputSymbol
    }
    
    
    
}

