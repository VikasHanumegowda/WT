package com.example.vikashanumegowda.hw9_android;

/**
 * Created by vikashanumegowda on 11/29/17.
 */

public class SuggestGetSet {

    String id,label;
    public SuggestGetSet(String id, String label){
        this.setId(id);
        this.setName(label);
    }
    @Override
    public String toString(){
        return id;
    }
    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getName() {
        return label;
    }

    public void setName(String label) {
        this.label = label;
    }

}
