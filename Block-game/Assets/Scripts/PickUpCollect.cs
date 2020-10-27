using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class PickUpCollect : MonoBehaviour {
    public float timer;
    public bool isColected;
    GameObject pick;
    public Transform player;
    public GroundCreator ground;
	
	// Update is called once per frame
	void Update () {
        if (ground.level >= 12)
        {
            timer += Time.deltaTime;
            if (timer >= 10.0f)
            {
                isColected = false;
                GameObject prefab = Resources.Load("PickUp") as GameObject;
                pick = Instantiate(prefab) as GameObject;
                int x = Random.Range(-24, 24);
                int z = Random.Range(-24, 24);
                pick.transform.position = new Vector3(x, 2, z);
                timer = 0;
                if (isColected == false) StartCoroutine(DestoyPick());
            } 
        }
    }

    IEnumerator DestoyPick()
    {
        yield return new WaitForSeconds(5);
        Destroy(pick);
    }
}
