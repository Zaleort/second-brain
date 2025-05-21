package com.zaleort.second_brain.Shared.Infrastructure.JwtManager

import com.zaleort.second_brain.Users.Domain.User.UserId
import com.zaleort.second_brain.Users.Domain.User.UserRepositoryInterface
import org.springframework.security.core.userdetails.User
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.security.core.userdetails.UserDetailsService
import org.springframework.stereotype.Service

@Service
class JwtUserDetailsService(
    private val userRepository: UserRepositoryInterface,
): UserDetailsService {
    override fun loadUserByUsername(id: String): UserDetails {
        println("Loading user by ID: $id")
        val user = userRepository.findById(UserId(id))
            ?: throw Exception("User not found")

        return User.builder()
            .username(user.id.value)
            .password(user.password.value)
            .authorities("ROLE_USER")
            .build()
    }
}