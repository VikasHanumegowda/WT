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
    
    
    var picker1Options : [String]!
    
    var picker2Options : [String]!
    
    @IBOutlet weak var outputlabel: UILabel!
    @IBOutlet weak var symbolIP: UITextField!
    
    @IBOutlet weak var pickerView: UIPickerView!
    
    @IBOutlet weak var pickerV: UIPickerView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        picker1Options = ["Option 1","Option 2","Option 3","Option 4","Option 5"]
        picker2Options = ["Item 1","Item 2"]
    }

    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        if (pickerView.tag == 1){
            return picker1Options.count
        }else{
            return picker2Options.count
        }
        
    }

    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String?{
        if(pickerView.tag == 1){
            return picker1Options[row]
            
        }
        else{
            return picker2Options[row]
        }
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

