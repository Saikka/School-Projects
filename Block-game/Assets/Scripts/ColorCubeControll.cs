using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class ColorCubeControll : MonoBehaviour {
    GameObject ground;
    public GroundCreator groundControll;

    void Awake()
    {
        ground = GameObject.FindGameObjectWithTag("GameController");
        groundControll = ground.GetComponent<GroundCreator>();


    }

    // Use this for initialization
    void Start () {
        GetComponent<Image>().color = groundControll.mainColor;
    }
	
	// Update is called once per frame
	void Update () {
        GetComponent<Image>().color = groundControll.mainColor;
    }
}
