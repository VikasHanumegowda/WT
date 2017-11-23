//
//  ViewController.swift
//  homework9
//
//  Created by Vikas Hanumegowda on 11/22/17.
//  Copyright © 2017 Vikas Hanumegowda. All rights reserved.
//

import UIKit

class ViewController: UIViewController {

    @IBOutlet weak var outputlabel: UILabel!
    @IBOutlet weak var symbolIP: UITextField!
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
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

