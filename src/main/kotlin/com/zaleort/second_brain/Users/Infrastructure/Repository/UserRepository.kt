package com.zaleort.second_brain.Users.Infrastructure.Repository

import com.zaleort.second_brain.Users.Domain.User.User
import com.zaleort.second_brain.Users.Domain.User.UserEmail
import com.zaleort.second_brain.Users.Domain.User.UserId
import com.zaleort.second_brain.Users.Domain.User.UserRepositoryInterface
import org.springframework.stereotype.Repository
import java.util.UUID

@Repository
class UserRepository(
    private val jpaUserRepository: JpaUserRepository
) : UserRepositoryInterface {
    override fun findById(id: UserId): User? {
        val uuid = UUID.fromString(id.value)
        val entity = jpaUserRepository.findById(uuid).orElse(null)
        return entity?.let {
            User.fromPrimitives(
                id = it.id.toString(),
                email = it.email,
                password = it.password
            )
        }
    }

    override fun findByEmail(email: UserEmail): User? {
        val entity = jpaUserRepository.findByEmail(email.value)
        if (entity == null) {
            return null
        }
        return entity.let {
            User.fromPrimitives(
                id = it.id.toString(),
                email = it.email,
                password = it.password
            )
        }
    }

    override fun save(user: User) {
        val userEntity = UserEntity(
            id = UUID.fromString(user.id.value),
            email = user.email.value,
            password = user.password.value
        )

        jpaUserRepository.save(userEntity)
    }

    override fun delete(id: UserId) {
        val uuid = UUID.fromString(id.value)
        val userEntity = jpaUserRepository.findById(uuid).orElse(null)
        if (userEntity == null) {
            throw Exception("User not found: " + id.value)
        }

        jpaUserRepository.delete(userEntity)
    }
}