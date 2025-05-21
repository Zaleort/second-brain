package com.zaleort.second_brain.Users.Infrastructure.Controllers

import com.zaleort.second_brain.Users.Application.UseCases.Login.LoginCommand
import com.zaleort.second_brain.Users.Application.UseCases.Login.LoginDTO
import com.zaleort.second_brain.Users.Application.UseCases.Login.LoginHandler
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController

@RestController
class LoginController(val handler: LoginHandler) {

    @PostMapping("/api/v1/login")
    fun login(@RequestBody command: LoginCommand): ResponseEntity<LoginDTO> {
        val loginDTO = handler.execute(command)
        return ResponseEntity(loginDTO, HttpStatus.OK)
    }
}