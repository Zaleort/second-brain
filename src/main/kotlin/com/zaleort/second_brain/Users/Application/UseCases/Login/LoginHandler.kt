package com.zaleort.second_brain.Users.Application.UseCases.Login

import com.zaleort.second_brain.Shared.Domain.JwtManager.JwtPayload
import com.zaleort.second_brain.Shared.Infrastructure.JwtManager.JwtManager
import com.zaleort.second_brain.Users.Domain.User.Exceptions.InvalidCredentialsException
import com.zaleort.second_brain.Users.Domain.User.UserEmail
import com.zaleort.second_brain.Users.Domain.User.UserRepositoryInterface
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder
import org.springframework.stereotype.Service

@Service
class LoginHandler(
    val repository: UserRepositoryInterface,
    val jwtManager: JwtManager,
) {
    fun execute(command: LoginCommand): LoginDTO {
        val userEmail = UserEmail(command.email)
        val user = this.repository.findByEmail(userEmail)
            ?: throw InvalidCredentialsException("Invalid user or password")

        val encoder = BCryptPasswordEncoder()
        println(user.password.value)
        println(command.password)
        if (!encoder.matches(command.password, user.password.value)) {
            throw InvalidCredentialsException("Invalid user or password")
        }

        val token = jwtManager.encode(JwtPayload(user.id.value))
        return LoginDTO(token)
    }
}