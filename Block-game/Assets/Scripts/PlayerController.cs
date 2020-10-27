using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class PlayerController : MonoBehaviour {

    public float speed = 6f;
    public float timer;

    public PickUpCollect pickUp;
    Vector3 movement;
    Animator anim;
    Rigidbody playerRigidbody;
    int floorMask;
    float camRayLength = 100f;

    bool running = false;



    void Awake () {
        floorMask = LayerMask.GetMask("Floor");
        anim = GetComponent<Animator>();
        playerRigidbody = GetComponent<Rigidbody>();
    }

    void FixedUpdate()
    {
        float h = Input.GetAxisRaw("Horizontal");
        float v = Input.GetAxisRaw("Vertical");

        Move(h, v);
        Turning();
        Animating(h, v);
    }

    private void Move(float h, float v)
    {
        movement.Set(h, 0f, v);
        movement = movement.normalized * speed * Time.deltaTime;
        playerRigidbody.MovePosition(transform.position + movement);
    }

    void Animating(float h, float v)
    {
        bool walking = h != 0 || v != 0;
        anim.SetBool("IsWalking", walking);
        anim.SetBool("IsRunning", running);
    }

    void Turning()
    {
        Ray camRay = Camera.main.ScreenPointToRay(Input.mousePosition);
        RaycastHit floorHit;

        if (Physics.Raycast(camRay, out floorHit, camRayLength, floorMask))
        {
            Vector3 playerToMouse = floorHit.point - transform.position;
            playerToMouse.y = 0f;

            Quaternion newRotation = Quaternion.LookRotation(playerToMouse);
            playerRigidbody.MoveRotation(newRotation);
        }
    }

    void OnCollisionEnter(Collision col)
    {
        if (col.gameObject.tag == "PickUp")
        {
            Destroy(col.gameObject);
            pickUp.isColected = true;
            speed = 10f;
            running = true;
            StartCoroutine(PowerUpWearOff());
        }
    }

    IEnumerator PowerUpWearOff()
    {
        yield return new WaitForSeconds(4);
        speed = 6f;
        running = false;
    }
}
